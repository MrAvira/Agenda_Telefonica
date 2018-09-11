<?php

class ContatoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $dbTable = new Application_Model_DbTable_Contatos();
        //$retorno = $dbTable->fetchAll(array('idContato = ?'=>'2','sobrenome = ?'=>'Um')); exemplo de fetchAll com WHERE
        $retorno = $dbTable->fetchAll();
        $this->view->retorno = $retorno;  
        
    }

    public function novoAction()
    {
        $dados = $_GET;
        // verifica se existe dados no GET
        if(!is_null($dados) && !empty($dados)){
            // verifica se os dados vieram do submit do formulario de criar (novo)
            if(array_key_exists('action',$dados)){
                //$this->_forward('index','contato');
                // Insire um novo dado da tabela
                
                $newArray = array();
                if(array_key_exists('telefones',$dados)){
                    foreach (array_keys($dados['telefones']) as $fieldKey) {
                        foreach ($dados['telefones'][$fieldKey] as $key=>$value) {
                            $newArray[$key][$fieldKey] = $value;
                        }
                    } 
                }



                $dbTable = new Application_Model_DbTable_Contatos();
                $ultimoIdInserido = $dbTable->insert(array(
                    'nome'          => $dados['nome'],
                    'sobrenome'     => $dados['sobrenome'],
                    'email'         => $dados['email'],
                    'endereco'      => $dados['endereco'],
                    'numero'        => $dados['numero'],
                    'complemento'   => $dados['complemento'],
                    'cep'           => $dados['cep'],
                    'organizacao'   => $dados['organizacao'],
                    'descricao'     => $dados['descricao']
                ));

                if(!is_null($newArray) && !empty($newArray)){
                    $dbTable = new Application_Model_DbTable_Telefones();
                    foreach ($newArray as $value) {

                        if($value['numero'] != ''){
                            $dbTable->insert(array(
                                'idContato' => $ultimoIdInserido,
                                'numero' => $value['numero'] 
                            ));
                        }
                    }
                }

                $this->redirect('/contato');
            }
        }
    }

    public function editarAction()
    {
        $dados = $_GET;
        // verifica se existe dados no GET
        if(!is_null($dados) && !empty($dados)){
            // verifica se os dados vieram do submit do formulario de editar
            if(array_key_exists('action',$dados)){
                // salva as alterações do contato no banco de dados
                $dbTable = new Application_Model_DbTable_Contatos();
                $dbTable->update(array(
                    'nome'          => $dados['nome'],
                    'sobrenome'     => $dados['sobrenome'],
                    'email'         => $dados['email'],
                    'endereco'      => $dados['endereco'],
                    'numero'        => $dados['numero'],
                    'complemento'   => $dados['complemento'],
                    'cep'           => $dados['cep'],
                    'organizacao'   => $dados['organizacao'],
                    'descricao'     => $dados['descricao']
                ),array(
                    'idContato = ?' => $dados['idContato']
                ));
                
                $arrayTelefones = array();
                if(array_key_exists('telefones',$dados)){
                    foreach (array_keys($dados['telefones']) as $fieldKey) {
                        foreach ($dados['telefones'][$fieldKey] as $key=>$value) {
                            $arrayTelefones[$key][$fieldKey] = $value;
                        }
                    } 
                }
                $dbTable = new Application_Model_DbTable_Telefones();

                foreach ($arrayTelefones as $value) {
                    if( ($value['idTelefone'] == '') && 
                        (empty($value['idTelefone'])) && 
                        (strlen($value['numero']) > 0)
                    ){
                        $dbTable->insert(array('idContato' => $dados['idContato'],'numero' => $value['numero']));
                    }else{
                        $dbTable->update(array('numero' => $value['numero']),array('idTelefone = ?' => $value['idTelefone']));
                    }
                }

                foreach (explode(";",$dados['telefonesExcluir']) as $value) {
                    $dbTable->delete(array('idTelefone = ?' => $value));
                }
                //$this->_forward('index','contato');
                $this->redirect('/contato');
            }else{
                // como não tem a flag do form de excluir, significa que os dados vieram de outro lugar, então pasará os dados para view/formulario
                $dbTable = new Application_Model_DbTable_Contatos();
                $contato = $dbTable->fetchRow(array('idContato = ?' => $dados['idContato']));
                $this->view->dados = array(
                    'idContato'     =>$contato->idContato,
                    'nome'          =>$contato->nome,
                    'sobrenome'     =>$contato->sobrenome,
                    'descricao'     =>$contato->descricao,
                    'organizacao'   =>$contato->organizacao,
                    'email'         =>$contato->email,
                    'endereco'      =>$contato->endereco,
                    'numero'        =>$contato->numero,
                    'complemento'   =>$contato->complemento
                );

                $dbTable = new Application_Model_DbTable_Telefones();
                $telefones = $dbTable->fetchAll(array('idContato = ?' => $contato->idContato));

                foreach ($telefones as $value) {
                    echo '<br><br>';
                    $this->view->dados['telefones'][] = array(
                        'idContato' => $value['idContato'],
                        'idTelefone' => $value['idTelefone'],
                        'numero' => $value['numero']
                    );
                }
            }
        }


    }

    public function excluirAction()
    {
        echo $this->getRequest()->getParam('num1');
        echo $this->getRequest()->getParam('num2');
        //$this->_forward('index','contato');
        
        $dados = $_GET;
        if (!is_null($dados) && !empty($dados) && array_key_exists('idContato',$dados)) {
            // excluir contato
            $dbTable = new Application_Model_DbTable_Contatos();
            $dbTable->delete(array(
                'idContato = ?' => $dados['idContato']
            ));
            $this->redirect('/contato');
        }
    }


}







