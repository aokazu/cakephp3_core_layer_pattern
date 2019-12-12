<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Musics Controller
 *
 * @property \App\Model\Table\MusicsTable $Musics
 *
 * @method \App\Model\Entity\Music[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MusicsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $musics = $this->paginate($this->Musics);

        $this->set(compact('musics'));
    }

    /**
     * View method
     *
     * @param string|null $id Music id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $music = $this->Musics->get($id, [
            'contain' => []
        ]);

        $this->set('music', $music);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $music = $this->Musics->newEntity();
        if ($this->request->is('post')) {
            $music = $this->Musics->patchEntity($music, $this->request->getData());
            if ($this->Musics->save($music)) {
                $this->Flash->success(__('The music has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The music could not be saved. Please, try again.'));
        }
        $this->set(compact('music'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Music id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $music = $this->Musics->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $music = $this->Musics->patchEntity($music, $this->request->getData());
            if ($this->Musics->save($music)) {
                $this->Flash->success(__('The music has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The music could not be saved. Please, try again.'));
        }
        $this->set(compact('music'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Music id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $music = $this->Musics->get($id);
        if ($this->Musics->delete($music)) {
            $this->Flash->success(__('The music has been deleted.'));
        } else {
            $this->Flash->error(__('The music could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
