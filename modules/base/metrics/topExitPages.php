<?php

//
// Open Web Analytics - An Open Source Web Analytics Framework
//
// Copyright 2006 Peter Adams. All rights reserved.
//
// Licensed under GPL v2.0 http://www.gnu.org/copyleft/gpl.html
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// $Id$
//

/**
 * Top Exit Pages Metric
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_topExitPages extends owa_metric {
	
	function owa_topExitPages($params = null) {
		
		$this->params = $params;
		
		$this->owa_metric();
		
		return;
		
	}
	
	function calculate() {
		
		$db = owa_coreAPI::dbSingleton();
		
		$db->selectFrom('owa_session', 'session');
		$db->selectColumn("count(session.id) as count,
									document.page_title,
									document.page_type,
									document.url,
									document.id");
		

		// pass constraints into where clause
		$db->multiWhere($this->getConstraints());

		$db->join(OWA_SQL_JOIN_LEFT_OUTER, 'owa_document', 'document', 'last_page_id', 'document.id');
		$db->groupBy('session.last_page_id');
		$db->orderBy('count');
		
		
		return $db->getAllRows();

		
		
		/*

		
		$s = owa_coreAPI::entityFactory('base.session');
		
		$d = owa_coreAPI::entityFactory('base.document');
		
		$this->params['related_objs'] = array('last_page_id' => $d);
		
		$this->setTimePeriod($this->params['period']);
		
		$this->params['select'] = "count(session.id) as count,
									document.page_title,
									document.page_type,
									document.url,
									document.id";
								
		$this->params['groupby'] = array('session.last_page_id');
		
		$this->params['orderby'] = array('count');
	
		return $s->query($this->params);

*/		
	}
	
	
}


?>