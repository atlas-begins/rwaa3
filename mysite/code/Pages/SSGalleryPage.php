<?php
class SSGalleryPage extends Page {
	
	public static $icon = array('mysite/images/treeicons/SSGalleryPage', 'file');

	static $singular_name = 'Gallery Page';
	static $plural_name = 'Gallery Pages';
	
	static $has_one = array(
		'Folder' => 'Folder'
	);
	
	static $db = array(
		'HomePageView' => 'Boolean',
		'SlideTime' => 'Int'
	);
	
	static $defaults = array(
		'HomePageView' => false,
		'SlideTime' => '3000'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$imageSizeMessage = '<p>Please ensure your images are resized to 800 pixels wide x 600 pixels tall before uploading.<br />';
		$imageSizeMessage .= 'Inconsistent images will be shown with a padding.</p>';
		$timeArray = array('2000' => '2 seconds', '3000' => '3 seconds', '4000' => '4 seconds', '5000' => '5 seconds');
		$folder = new TreeDropdownField( 'FolderID', 'Show images from the following folder:', 'Folder');
		$folder->setFilterFunction( create_function( '$obj', 'return $obj->class == "Folder";'));
		$fields->addFieldToTab('Root.GalleryFiles' , $folder);
		$fields->addFieldToTab('Root.GalleryFiles', new CheckboxField('HomePageView', 'Show on home page? (will override all other galleries on this site)'));
		$fields->addFieldToTab('Root.GalleryFiles', new LiteralField('ImageMessage1', $imageSizeMessage));
		$fields->addFieldToTab('Root.GalleryFiles', new OptionSetField('SlideTime', 'Time per slide:', $timeArray, '3000'));
		return $fields;
	}
	
	/**
	 * 
	 * resets the HomePageView flag to false for all other galleries
	 */
	public function onAfterWrite() {
		$homePageView = $this->HomePageView;
		if($homePageView) {
			$results = DataObject::get("SSGalleryPage");
			if($results) {
				foreach($results as $result) {
					if($result->ID !== $this->ID){
						$result->HomePageView = false;
						$result->write();
					}
				}
			}
		}
	}
}

class SSGalleryPage_Controller extends Page_Controller {

}
?>