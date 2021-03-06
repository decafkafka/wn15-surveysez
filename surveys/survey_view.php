<?php
/**
 * index.php, functionally survey_list.php
 *
 * survey_list.php works with survey_view.php to create a list/view app
 *
 * Based on demo_list_pager.php along with demo_view_pager.php provides a sample web application
 *
 * The difference between demo_list.php and demo_list_pager.php is the reference to the 
 * Pager class which processes a mysqli SQL statement and spans records across multiple  
 * pages. 
 *
 * The associated view page, demo_view_pager.php is virtually identical to demo_view.php. 
 * The only difference is the pager version links to the list pager version to create a 
 * separate application from the original list/view. 
 * 
 * @package SurveySez
 * @author Young Han <yhan0010@seattlecentral.edu>
 * @version 1.0 2015/03/02
 * @link http://www.younghan.org/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see survey_view.php
 * @see Pager_inc.php 
 * @todo Create suvey_view.php page
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to demo_list_pager.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}

$mySurvey = new Survey($myID);
if($mySurvey->isValid)
{
	$config->titleTag = $mySurvey->Title . " survey!";
}else{//no such survey
	$config->titleTag = "No such survey";

}
//dumpDie($mySurvey);

//---end config area --------------------------------------------------
get_header(); #defaults to theme header or header_inc.php

echo '
<h3 align="center">' . $config->titleTag . '</h3>
	';

if($mySurvey->isValid)
{ #check to see if we have a valid SurveyID
	echo $mySurvey->SurveyID . "<br />";
	echo $mySurvey->Title . "<br />";
	echo $mySurvey->Description . "<br />";
	$mySurvey->showQuestions();
	echo SurveyUtil::responseList($myID);
}else{
	echo "Sorry, no such survey!";
}

get_footer(); #defaults to theme footer or footer_inc.php

require '../inc_0700/Survey_inc.php';