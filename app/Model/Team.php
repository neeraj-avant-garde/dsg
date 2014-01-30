<?php

App::uses('AppModel', 'Model');

class Team extends AppModel {

    public $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'joinTable' => 'team_users',
            'foreignKey' => 'team_id',
            'associationForeignKey' => 'user_id',
        )
    );
    public $belogsTo = array('Dailypriority');

    public function beforeSave($options = array()) {
        foreach (array_keys($this->hasAndBelongsToMany) as $model) {
            if (isset($this->data[$this->name][$model])) {
                $this->data[$model][$model] = $this->data[$this->name][$model];
                unset($this->data[$this->name][$model]);
            }
        }
        return true;
    }

    public function team_users($id, $quarterid) {
        $sql = "SELECT * FROM team_users 
					JOIN priorities ON team_users.user_id=priorities.user_id 
					JOIN users ON team_users.user_id=users.id 
				WHERE team_users.team_id='" . $id . "' AND priorities.quarter_id='" . $quarterid . "' ";
        return $this->query($sql);
    }

    public function team_priorities($teamId, $quarterid) {
        $sql = "SELECT Priority.id, Priority.name, Priority.target, Priority.completed FROM team_users 
					JOIN priorities Priority ON team_users.user_id=Priority.user_id 
					JOIN users ON team_users.user_id=users.id 
				WHERE team_users.team_id='" . $teamId . "' AND Priority.quarter_id='" . $quarterid . "' ";
        return $this->query($sql);
    }

    public function team_edit($id, $teamid) {
        $sql = "SELECT * from team_users 
					JOIN priorities ON team_users.user_id=priorities.user_id 
					JOIN users ON team_users.user_id=users.id 
					where priorities.id='" . $id . "' && team_users.team_id='" . $teamid . "'";
        return $this->query($sql);
    }

    public function team_set($objective, $assigned, $completed, $updated, $priority, $team) {
        $sql = "UPDATE team_users 
					JOIN priorities ON team_users.user_id=priorities.user_id 
					JOIN users ON team_users.user_id=users.id 
						SET priorities.name='" . $objective . "',
						users.firstname='" . $assigned . "',
						priorities.completed='" . $completed . "',
						priorities.modified='" . $updated . "'
					WHERE priorities.id='" . $priority . "' && team_users.team_id='" . $team . "'";
        return $this->query($sql);
    }

    public function team_delete($id, $teamid) {
        $sql = " DELETE team_users FROM team_users 
					JOIN priorities ON team_users.user_id=priorities.user_id 
					JOIN users ON team_users.user_id=users.id  
					where priorities.id='" . $id . "' && team_users.team_id='" . $teamid . "'";
        return $this->query($sql);
    }

}
