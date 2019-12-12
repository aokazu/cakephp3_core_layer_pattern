<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Table\MusicsTable;
use App\Model\Table\UsersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use CakeCms\User\Application\Adapter\UserMusicAdapter;
use CakeCms\User\Core\UseCase\UserMusicSelector;

$user_dir = dirname(__FILE__) . "/../../packages/CakeCms/User";
require_once($user_dir . '/Application/Adapter/UserMusicAdapter.php');
require_once($user_dir . '/Core/Port/UserMusicPort.php');
require_once($user_dir . '/Core/UseCase/UserMusicSelector.php');


/**
 * Users Controller
 *
 * @property UsersTable $Users
 * @property MusicsTable $Musics
 *
 * @method User[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * @param int $user_id
     */
    public function selectMusic(int $user_id)
    {
        //ユーザーと音楽モデルをセットしてプラグを作成
        $this->loadModel('Musics');
        $plug = new UserMusicAdapter(
            $this->Users,
            $this->Musics
        );
        //UserMusicSelectorプログラムにプラグを差し込んでRunすると最適な音楽を抽出する。
        $useCase = new UserMusicSelector($plug);
        $data = $useCase->run($user_id);
        //viewに値セット
        $this->set(compact('data'));
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Articles']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
