<?php

/**
 * Partners list view model class
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Partners_ListView_Model extends Vtiger_ListView_Model
{

	/**
	 * Function to get the list of Mass actions for the module
	 * @param array $linkParams
	 * @return array - Associative array of Link type to List of  Vtiger_Link_Model instances for Mass Actions
	 */
	public function getListViewMassActions($linkParams)
	{
		$links = parent::getListViewMassActions($linkParams);
		$currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$moduleModel = $this->getModule();
		$massActionLinks = [];
		if ($moduleModel->isPermitted('MassComposeEmail') && AppConfig::main('isActiveSendingMails') && App\Mail::getDefaultSmtp()) {
			$massActionLinks[] = array(
				'linktype' => 'LISTVIEWMASSACTION',
				'linklabel' => 'LBL_MASS_SEND_EMAIL',
				'linkurl' => 'javascript:Vtiger_List_Js.triggerSendEmail()',
				'linkicon' => ''
			);
		}
		foreach ($massActionLinks as $massActionLink) {
			$links['LISTVIEWMASSACTION'][] = Vtiger_Link_Model::getInstanceFromValues($massActionLink);
		}
		return $links;
	}
}
