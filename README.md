# Framework PHP

Esta é uma implementação simples do modelo de arquitetura MVC em PHP, onde busca
oferecer recursos já nativos de otimização para a WEB.

## Sumário

- [A estrutura da framework](#a-estrutura-da-framework)
  - [Estrutura de pastas](#estrutura-de-pastas)
    - [Arquivos de configurações](#arquivos-de-configurações)
    - [Layouts de sistema](#layouts-de-sistema)
    - [Arquivos de logs de execução](#arquivos-de-logs-de-execução)
    - [Camada modelo](#camada-modelo)
      - [Repositórios](#repositórios)
    - [Camada de controle](#camada-de-controle)
    - [Camada de visualizações](#camada-de-visualizações)
    - [Camada de serviços](#camada-de-serviços)
    - [Arquivos públicos e recursos](#arquivos-públicos-e-recursos)
  - [Recursos auxiliares](#recursos-auxiliares)
    - [Links](#links)
    - [Listagem de registros](#listagem-de-registros)


## A estrutura da framework

### Estrutura de pastas

A framework implementa a arquitetura MVC, sendo assim os códigos ficam separados
em classes de tratamento de dados e regra de negócios (Model), classes que
intermediam o uso dos dados e regras para as telas (Controller) e os arquivos de
telas onde ficam todo o HTML (View).

A estrutura de pastas é a seguinte:

| Pasta        | Descrição                                                   |
|--------------|-------------------------------------------------------------|
| config       | Arquivos de configuração do projeto.                        |
| layouts      | HTMLs de layouts utilizados para layouts de páginas.        |
| logs         | Relatórios de erros ocorridos durante a execução do sistema.|
| models       | Camada Modelo (Model), isto é, classes para manipulação e tratamento de dados. |
| modules      | Camada de controle (Controller), isto é, classes responsáveis por identificar a ação requisitada, instanciar as Models necessárias para executar a ação, e por fim exibir a tela (View) apropriada. |
| public       | Aqui estão todos os arquivos públicos do projeto, como imagens, arquivos de estilo (CSS), códigos em javascript, fontes de texto, etc. |
| resources    | Arquivos utilizados pelo sistema que para executar algumas funções comuns, como envio de e-mail, telas de erros, componentes para listagens de registro, entre outros. |
| services     | A camada de serviço (Service) é um complemento ao MVC, possibilitando o reuso de regras de negócio em qualquer parte do sistema, como por exemplo o mecanismo de autenticação de usuário, upload de arquivos ou tratamento de imagens. |

#### Arquivos de configurações

Dentro da pasta “config” estão os arquivos para toda a configuração necessária
para a execução do sistema. Sendo eles:

| Arquivo      | Descrição                                                   |
|--------------|-------------------------------------------------------------|
| core.php     | Configurações básicas do sistema, como ambiente de execução, URL base, e-mail para envio de relatório de erros, caminho para salvar arquivos de erros, etc. |
| database.php | Configurações de conexão com o banco de dados por ambiente. |
| routes.php   | Tratamento de URLs para definição de rotas do sistema, isto é, define como irá tratar uma determinada URL, indicando para qual Controller e ação deverá redirecionar, assim como os parâmetros que devem ser passados. |

#### Layouts de sistema

Os layouts de sistema são usados para reaproveitar o código HTML comum para
todas as telas. Por exemplo, se é necessário que uma lista de links sejam
exibidos em todas as páginas do sistema, devemos coloca-los em um arquivo
com o nome nor formato `nomedolayout.lay.php` dentro da pasta `layouts`. Assim,
para cada requisição, os links serão incluídos junto às Views.

Para cada Controller ou ações, é permitido utilizar um layout específico. Por
exemplo, no controller abaixo a ação index utiliza o layout com nome padrão da
framework `default.lay.php` por isso não foi especificado nada, já na ação login
foi utilizado o layout do arquivo `system.lay.php`, veja:

```php
class IndexController extends Controller
{
    public function index()
    {
    }

    public function login()
    {
		$this->view->layout->layoutName = 'system';
    }
}
```

Veja que para definir atributos ao layout, foi utilizado `$this->view->layout`.
Os atributos pré-definidos são:

| Atributo      | Descrição                                                    |
|---------------|--------------------------------------------------------------|
| layoutName    | Nome do layout a ser renderizado.                            |
| content       | Conteúdo da view que será exibida no layout. Evite sobreescrever este o valor deste atributo. |
| title         | Título da página utilizado na tag `<title>`, por exemplo `<title><?php echo $this->title ?></title>`.


#### Arquivos de logs de execução

Os arquivos de logs gerados pelo sistema, possuem uma mensagem indicando qual o
erro ocorrido e todas as informações da requisição. Depedendo da configuração no
arquivo `core.php` o log pode ser gravado na pasta log, enviado apenas por email
ou ambos.

#### Camada modelo

A camada modelo lida com todas as regras para manipulação dos dados do banco de
dados, seja para a listagem, busca, criação ou atualização de registros. Os
arquivos desta camada utilizam o sufixo “mdl” em seus nomes, como por exemplo,
`NomeDaModel.mdl.php`.

Para criar uma classe modelo e ter acesso a uma tabela do banco de dados, basta
criar um arquivo com o nome da tabela (sem prefixo) no padrão descrito acima e
escrever uma classe da seguinte maneira:

```php
/**
 * Nome da tabela: sys_contact_subject
 * Prefixo definido no arquivo "database.php": sys
 * Arquivo: ContactSubject.mdl.php
 */
class ContactSubject extends Model
{
    /**
     * Guarda o nome da da tabela do banco de dados usada pelo modelo.
     *
     * @var string
     */
    protected $_tableName = 'contact_subject';
}
```

Para obter um resgitro basta instanciar essa classe passando um valor da chave
primária. Abaixo está um exemplo de como inserir ou alterar o valor do campo
`name` de um registro da tabela `sys_contact_subject`.

```php
// Inserindo um novo registro
$Obj = new ContactSubject();
$Obj->name = 'Sugestões';
$Obj->save();

// Alterando um registro
$Obj = new ContactSubject(1);
$Obj->name = 'Dúvidas';
$Obj->save();
```

A classe `Model` ao qual nossa classe está extendendo, possui vários métodos
para auxiliar a manipulação e recuperação de dados.

##### Repositórios

A camada modelo possui uma subdivisão opcional para definir os repositórios
(Repositories), que lida com a definição da estrutura das tabelas do banco de
dados utilizadas pela camada modelo. O sufixo utilizado para os arquivos de
repositório é “rep”, ou seja, `NomeDoRepositorio.rep.php`.

O uso dos repositórios é útil para aumentar a performace e diminuir o número de
consultas ao banco de dados. Para facilitar a criação, utilize a
[Framework-Tools](https://github.com/marcusagm/Framework-Tools) para gerar as
classes models.

#### Camada de controle

Os Controller são responsáveis por definir como serão executadas as ações
requisitadas. Cada método público de suas classes são vistas como uma ação
(action), que poderão ser executadas via requisição HTTP.

Por padrão, para executar um Controller a chamada HTTP poderá ser realizada
através de uma URL com a seguinte estrutura:

```
http://www.dominio.com.br/[nome_do_controller]/[action]/[parâmetros]
```

Os Controllers podem ser agrupados em um módulo (Module) para melhorar a
organização do projeto e permitir a utilização de vários Controllers com o mesmo
nome. Para isto, basta agrupar todos os Controllers desejados dentro de uma
pasta com o nome do módulo, e registrar o módulo criado no arquivo de
configurações de rotas.

```php
/**
 * Arquivo: config/route.php
 */
$ConfigRoutes = ConfigRoutes::getInstance();

// Registrando o módulo "amdin"
$ConfigRoutes->addModule( 'admin' );
```

Após criar um módulo, a URL de acesso a um Controller terá o nome do módulo
antes do nome do Controller, ficando da como a seguir:

```
http://www.dominio.com.br/[modulo]/[controller]/[action]/[parâmetros]
```

É possível criar função de cadastro, atualização, listagem e exclusão (CRUD)
utilizando a classe `CrudController`, que fornece a implementação completa dos
métodos necessários, que podem ser complementados para casos específicos.

```php
// Implementação de um Controller comum
class IndexController extends Controller
{
    public function index()
    {
    }
}

// Implemetação de um Controller para implementações de CRUDs
class CategoryController extends CrudController
{
}

```

#### Camada de visualizações

Dentro de cada pasta de Controller possui uma subpasta nomeada “views”, onde
está os arquivos HTML de cada tela de interação com o usuário. Os arquivos aqui
utilizam o sufixo “frm”, ou seja, `nomedaview.frm.php`.

Para possibilitar o reuso de trechos de código HTML, arquivos complementares
podem ser utilizados (Partials). Esses arquivos utilizam o sufixo “prt” e podem
ser incluídos em várias views diferentes.

Para passar uma variável do controller para a view basta usar
`$this->view->nomeDaVariavel` dentro de uma ação do controller e na view desta
ação, a variável poderá ser recuperada usando `$this->nomeDaVariavel`.

Passando um valor para a variável "message" para a view "index.frm.php":

```php
class IndexController extends Controller
{
    public function index()
    {
        $this->view->message = 'Olá mundo!';
    }
}
```

No arquivo da view podemos imprimir este valor.

```html
<h1>
    <?php echo $this->message ?>
</h1>
```

Normalmente as views que serão carregadas possuem o mesmo nome da ação do
controller com as letras todas em minúsculo. No exemplo acima, a ação `index`
carregou a view "index.frm.php".

Caso seja necessário carregar uma view com o nome diferente, informe na ação
o nome usando `$this->view->name = 'nomedaview';`. É comum recorrer a este
recurso para aproveitar views de formulários por exemplo.

```php
class CategoryController extends Controller
{
    public function add()
    {
        // Aproveita a view de um formulário
        $this->view->name = 'form';

        // Passa a váriavel record vazia para a view saber preencher os campos.
        $this->view->record = null;
    }

    public function edit($id)
    {
        $this->view->name = 'form';

        // Passa a váriavel record com um objeto para a view conseguir preencher
        // os campos.
        $this->view->record = Category($id);
    }
}
```

#### Camada de serviços

A camada de serviço é um complemento à arquitetura MVC, permitindo que regras de
negócio sejam criadas e reutilizadas em todo o sistema. Sendo assim, regras para
autenticação de usuários, uploads de arquivos, envios de email, entre outros,
podem ser criados e utilizados como for necessário. Os arquivos desta camada
possuem o sufixo “svc”, por exemplo `Authentication.svc.php`.

#### Arquivos públicos e recursos

Todos os arquivos que podem ser publicamente acessados estão dentro da pasta
“public”, assim o acesso a imagens, definições de estilos de página, arquivos
javascrips, etc, estarão acessíveis via requisição HTTP. Requisições para
arquivos inesitentes gerarão logs.

Os aruivos de recursos (Resources) são arquivos utilizados para padronizar ou
auxiliar algumas tarefas, como templates de email, tradução de páginas e
modelo de grid de listagem.

### Recursos auxiliares

#### Links

A framework possui uma classe para gerar link completos chamada “UrlMaker”.
Esta classe pode ser encontrada dentro da pasta da framework no caminho
`framework/libs/helpers/UrlMaker.php`.

Essa classe possui três métodos, sendo eles `toAction`, `toModuleAction` e
`toRoute`.

Utilize o método `toAction` quando estiver querendo um link onde o controller
não possui módulo, para os que possuir utilize `toModuleAction`. Quando desejar
utilizar um link que possui uma rota configurada no arquivo `routes.php`,
utilize `toRoute`.

Exemplos:

```php
// http://www.dominio.com/login/index/
UrlMaker::toAction( 'login', 'index' );

// http://www.dominio.com/system/user/profile/
UrlMaker::toModuleAction('system', 'user', 'profile');

// URL customizada
UrlMaker::toRoute( 'blog' );
```

#### Listagem de registros

A framework possui uma classe para gerar automaticamente uma tabela para listar
registros já com paginação. Esta classe pode ser encontrada dentro da pasta
framework no caminho `framework/libs/DataGrid.php` e para listagens onde os
registros são apresentados no formato de árvore,
`framework/libs/DataTreeGrid.php`.

Estas classes utilizam templates que podem ser localizados na pasta do projeto
no caminho `projeto/resources/pt_br/grid`.

#### CRUDController

O CRUDController é uma classe pré programada com métodos que facilitam a criação
de telas de cadastro, edição, listagem e exclusão. Esta classe pode ser
encontrada na pasta da framework no caminho
`framework/controller/CrudController.php`.

Nele possui métodos para apresentação dos formulários de adição
(“add” e “create”), edição (“edit” e “update”), exclusão
(“delete” e “deleteSelected”), visualização (“view”) e listagem (“index”).

A classe também possui métodos que permitem executar códigos entre a execução
predefinida, todas elas iniciam com “before” para código que devem ser
executados antes do algoritmo pronto, e “after” para códigos que devem ser
executados depois.

É possível notar que os métodos “add” e “edit” utilizam a mesma view onde o
arquivo possui o nome de “form.frm.php” isso ocorre pois dentro deste método o
nome da view é alterado, sobrescrevendo o padrão da framework onde as views
possuem o mesmo nome das actions (métodos públicos de uma controller).

A [Framework-Tools](https://github.com/marcusagm/Framework-Tools) pode auxiliar
a gerar todos os CRUDs baseando nas classes Models disponíveis.
