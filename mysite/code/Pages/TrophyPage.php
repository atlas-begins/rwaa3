<?php
class TrophyPage extends Page {

	private static $icon = "mysite/images/treeicons/SSTrophy_silver.png";
	
	private static $db = array(
	);
	
	private static $has_many = array();
	
	static $defaults = array(
		'ShowInMenus' => false
	);
	
	public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
	}
	
	public function writeTrophyNote($trophy = null, $msg = null) {
    	if($trophy && $msg) {
    		$result = new SSNote();
    		$result->NoteContents = $msg;
    		$result->AuthorID = Member::currentUser()->ID;
    		$result->TrophyID = $trophy->ID;
    		$result->write();
    	}
    	return true;
    }
}
class TrophyPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
	}
	
	private static $allowed_actions = array (
		'view' => true
		, 'edit' => 'ADMIN'
		, 'TrophyNoteForm' => TRUE
		, 'doSaveTrophy' => TRUE
	);
	
    public function view($request) {
    	if($result = SSTrophy::get()->byID($this->request->param('ID'))) {
    		$resultsArray = array(
    			'Title' => 'Records for "' . $result->TrophyName . '"'
    			, 'Result' => $result
    		);
    	} else {
    		$resultsArray = array(
    			'Title' => 'Trophy not found'
    			, 'Content' => '<p>Sorry, we cannot locate records for that trophy.</p><p>Please return to the main page and make another selection.</p>'
    		);
    	}
    	return $this->customise($resultsArray)->renderWith(array('TrophyPage', 'Page'));
    }
    
	public function TrophyNoteForm() {
    	$fields = new FieldList();
    	$fields->push(new TextareaField('NoteContents', ''));
    	$fields->push(new HiddenField('TrophyID', 'Trophy ID', $this->request->param('ID')));
    	$actions = new FieldList(
            new FormAction('doSaveTrophyNote', 'Save note')
        );
        $validator = new RequiredFields();
		$form = new Form($this, 'TrophyNoteForm', $fields, $actions, $validator);
		return $form;
    }
    
	public function doSaveTrophyNote($form, $data) {
    	if($result = SSTrophy::get_by_id("SSTrophy", $form['TrophyID'])) {
    		self::writeTrophyNote($result, $form['NoteContents']);
    		$returnURL = $this->Link() . 'view/' . $form['TrophyID'];
    	}
    	return $this->redirect($returnURL);
    }
}
