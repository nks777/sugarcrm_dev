<?php 
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

require_once('modules/Documents/Document.php');

class DocSaveTest extends Sugar_PHPUnit_Framework_TestCase
{
	var $doc = null;
	
	public function setUp()
    {
        global $current_user, $currentModule ;
		$mod_strings = return_module_language($GLOBALS['current_language'], "Documents");
		$current_user = SugarTestUserUtilities::createAnonymousUser();

		$document = new Document();
		$document->id = uniqid();
        $document->name = 'Test Document';
        $document->save();
		$this->doc = $document;
	}
	
    public function tearDown()
    {
        SugarTestUserUtilities::removeAllCreatedAnonymousUsers();
        unset($GLOBALS['current_user']);
        unset($GLOBALS['mod_strings']);
        
        $GLOBALS['db']->query("DELETE FROM documents WHERE id = '{$this->doc->id}'");
        unset($this->doc);
    }
	
	function testDocTypeSaveDefault() {
		// Assert doc type default is 'Sugar'
    	$this->assertEquals($this->doc->doc_type, 'Sugar');
	}

    function testDocTypeSaveDefaultInDb() {
        $query = "SELECT * FROM documents WHERE id = '{$this->doc->id}'";
        $result = $GLOBALS['db']->query($query);
    	while($row = $GLOBALS['db']->fetchByAssoc($result))
		// Assert doc type default is 'Sugar'
    	$this->assertEquals($row['doc_type'], 'Sugar');
	}

}
?>