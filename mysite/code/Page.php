<?php
class Page extends SiteTree {

	private static $db = array(
	);

	private static $has_one = array(
	);

	/**
	 * 
	 * fetches gallery page, first set with HomePageView, else just normal
	 * @return DataObject 
	 */
	public function homePageGallery() {
		switch ($this->ParentID) {
			case "0":
				//$result = DataObject::get_one("SSGalleryPage", "HomePageView = 1");
				$result = SSGalleryPage::get()->where("HomePageView = 1")->first();
				$result->NormalWidth = 400;
				$result->NormalHeight = 300;
			break;
			default:
				$result = $this;
				$result->NormalWidth = 640;
				$result->NormalHeight = 480;
			break;
		}
		return $result;
	}
	
	/**
	 * 
	 * returns images in folder specified in gallery page
	 * @return DataObjectSet
	 */
	public function galleryImages() {
		$useGalleryPage = self::homePageGallery();
		$usePage = Page::get()->byID($useGalleryPage->ID);
		if($useGalleryPage && $items = DataList::create("Image")->filter(array('ParentID' => $useGalleryPage->FolderID))->sort("Created", "DESC")) {
			foreach($items as $item) {
				$item->PaddedImage($useGalleryPage->NormalWidth, $useGalleryPage->NormalHeight);
				$item->GalleryLink = $usePage->Link();
				$item->GalleryTitle = $useGalleryPage->Title;
				//echo '<br>' . $useGalleryPage->Title;
			}
			//die();
			return $items;
		} else {
			return false;
		}
	}
	
	public function thisURL() {
		$returnURL = $this->Link();
		if(Controller::curr()->getRequest()->param('ID')) $returnURL .= Controller::curr()->getRequest()->param('Action') . '/' . Controller::curr()->getRequest()->param('ID');
		return $returnURL;
	}
    
	public function getCalendarPage() {
    	if($result = DataObject::get_one("CalendarPage")) {
			return $result->Link();
		}
		return false;
    }
}

class Page_Controller extends ContentController {

	private static $allowed_actions = array (
		
	);

	public function init() {
		parent::init();
		Requirements::javascript('themes/simple/javascript/tabcontent.js');
	}
}
