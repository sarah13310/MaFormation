<?php

namespace App\Controllers;

use App\Models\ContactModel;



class Contact extends BaseController
{

    private function createOptionobject($select=0)
    {
        $types = ["Votre objet", "Objet 1", "Objet 2","Objet 3" ];
        $selected_index=array_search($select,$types);
        $options = "";
        $index = 1;
        foreach ($types as $type) {
            $selected=($index == $selected_index)?"selected":"";
            $options .= "<option value='$index' $selected >$type</option>";
            $index++;
        }
        return $options;
    }
    
    public function index()
    {
        $data = ["title" => "Contact"];
        helper(['form']);
        $options=$this->createOptionobject();
        $data['options']=$options;
        if ($this->request->getMethod() == 'post') {

        $rules = [
            'name' => 'required|min_length[3]|max_length[20]',
            'content' => 'required|min_length[3]|max_length[128]',
            'mail' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.mail]',
        ];
        $error = [
            'name' => ['required' => "Nom vide!"],
            'content' => ['required' => "Message vide!"],
            'mail' => ['required' => "Adresse mail vide!"],
        ];

       
        if (!$this->validate($rules, $error)) {
            $data['validation'] = $this->validator;
            $main = false;
        }
            
            $model = new ContactModel();
                $newData = [
                    'name' => $this->request->getVar('name'),
                    'content' => $this->request->getVar('content'),
                    'mail' => $this->request->getVar('mail'),
                    'object'=>$this->request->getVar('index'),
                    
                ];
                
                $model->save($newData);
        }
        return view("Contact/index", $data);
    }
}
