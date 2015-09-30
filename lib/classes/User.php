<?php 
class User extends DB
{
	var $commonObjContent;
	var $encryObj;
	private static $RPVal=0;
        private static $value1='';
        private static $value2='';
        private static $leftArr='';
        private static $total=0;
	function __construct(){
		$this->commonObjContent=new Common();
		$this->encryObj = new Encryption();
		parent:: __construct(DB_NAME,DB_HOST,DB_USERNAME,DB_PASSWORD);		
	}	
	
	function CheckUserPosition($uid){
		$uid = 'SM100'.$uid;
		$query = "SELECT * FROM ".TBL_PREFIX."_users where status = 1 AND parent_id='".$uid."'";
		$result = $this->query($query);
		return $this->numRows($result);
	
	}
	function getTotalLeg($memid,$leg){ 
  			$sql = "select * from ".TBL_PREFIX."_users where parent_id='".$memid."' and position='".$leg."'";    
  			$res = $this->query($sql);  
  			
    
  			self::$total = self::$total + $this->numRows($res);
  			$row = $this->fetchNextObject($res);
 
			 if(!empty($row->uid)){ 
			   $uid = 'SM100'.$row->uid;
			   $this->getTotalLeg ($uid,'1');
			   $this->getTotalLeg ($uid,'2');
			  }

    		return self::$total;
    }
	
	function FindTotalUserId($memid,$leg){
  		 $sql="select * from ".TBL_PREFIX."_users where parent_id='".$memid."' and position='".$leg."'";    
  			$res=$this->query($sql);  
  			
  			$row=$this->fetchNextObject($res);
			if(!empty($row->uid)){
 			self::$value1  .= $row->uid.","; 
			 if($row->uid !=''){
			   $uid = 'SM100'.$row->uid;
			   $this->FindTotalUserId ($uid,'1');
			   $this->FindTotalUserId ($uid,'2');
			  }
			}
    		return self::$value1;
    }
	function UserPositionId($uid){
		$Arr = array();
		$query = "SELECT * FROM ".TBL_PREFIX."_users where parent_id = '".$uid."'";
		$result = $this->query($query);
		while($line = $this->fetchNextObject($result)){
			if($line->position == 1){
				$Arr['right'] = $line->uid;
			}else{
				$Arr['left'] = $line->uid;
			}
		}
		
		return $Arr;
	}
	function GenerateCommissionVal(){
		$query = "SELECT * FROM ".TBL_PREFIX."_users where 1=1 AND status = 1";
		$result = $this->query($query);
		$commissionConfig = $this->getCommissionConfig();
		
		
		while($line = $this->fetchNextObject($result)){
		
			$position = $this->CheckUserPosition($line->uid);
				if($position == 2){
                                        if(isset($line->user_pin)){
                                            $UserPackage = $this->getUserPackage($line->user_pin);
                                        }else{
                                            $UserPackage = null;
                                        }
                                        $dirIncome = $inDirIncome = 0;
					$uid = 'SM100'.$line->uid;
					$LegPosition = $this->UserPositionId($uid);
					
					$perviousVal = $this->FetchPreviousUserCommission($line->uid);
					
					if(!empty($perviousVal->inactive_user_id)){
						$InactiveUserId = $perviousVal->inactive_user_id;
					}else{
						$this->FindTotalUserId('SM100'.$LegPosition['right'],1);
						$value = $this->FindTotalUserId('SM100'.$LegPosition['left'],2);
						$value = trim($value, ",");
                                                self::$value1 = '';
						
                                                if(!empty($value) && $value != ''){
                                                    $InactiveUserId = $this->FindInactiveUserId($value);
                                                }else{
                                                    $InactiveUserId = 0;
                                                }
					}
					//echo 'Inactive user='.$InactiveUserId.'<br>';					
					$rightLeg = $this->getTotalLeg($uid,1); // right leg total user
                                        self::$total = 0;
					$leftLeg = $this->getTotalLeg($uid,2); 
					self::$total = 0;
					
					$minVal = 0;
					$rasio = 0;
					$RightfinalArr = explode(',',trim($this->getTotalLegRightUserId($uid,1), ","));	
                                        self::$value2 = 0;
					$LeftfinalArr = explode(',',trim($this->getTotalLegLeftUserId($uid,2), ","));
					self::$leftArr = '';
                                        
					if(!empty($perviousVal->right_remaining_users)){
						$RightRemainuserId = explode(',',$perviousVal->right_remaining_users);
						$rightLeg = $rightLeg + count($RightRemainuserId);						
						$RightfinalArr = array_merge($RightRemainuserId,$RightfinalArr);
					}
					if(!empty($perviousVal->left_remaining_users)){
						$LeftRemainuserId = explode(',',$perviousVal->left_remaining_users);
						$leftLeg = $leftLeg + count($LeftRemainuserId);						
						$LeftfinalArr = array_merge($LeftRemainuserId,$LeftfinalArr); 
					}
					
						$minVal = $rightLeg; // minimum user count accroding position
						$rasio = "$rightLeg : $leftLeg"; // for rasio						
						$commissionVal = 0; // store main commission
						
						
					if($rightLeg <= $leftLeg){	
																
						$temp = $LeftfinalArr; 						
						$Rcommission = 0;
						$Lcommission = 0;
						
						for($i=0;$i<$rightLeg;$i++){  //for right leg commission count							 
							$RightId = $RightfinalArr[$i];
							$UserDetail = $this->GetUserPackageDetail($RightId);
							
							if($UserDetail->uid != $InactiveUserId){
								$packagePoint = isset($UserDetail->package_point) ? $UserDetail->package_point : 0;
                                                                $CommStatus = $this->userCommissionStatus($line->uid);
                                                                if($this->numRows($CommStatus) > 0){
                                                                    while($record = $this->fetchNextObject($CommStatus)){
                                                                        $generatedUser = explode(':',$record->generated_comm_userid);
                                                                        if($UserDetail->uid != $generatedUser[1]){
                                                                            $Rcommission = $Rcommission +($packagePoint * $commissionConfig->point_value);
                                                                            $generated_comm_userid = $line->uid.":".$UserDetail->uid;
                                                                            $query = "INSERT INTO ".TBL_PREFIX."_generated_user_commission SET uid='".$line->uid."',generated_comm_userid='".$generated_comm_userid."',generated_date=CURDATE()";
                                                                            $this->query($query);
                                                                        }
                                                                    }
                                                                }else{
                                                                    $Rcommission = $Rcommission +($packagePoint * $commissionConfig->point_value);
                                                                    $generated_comm_userid = $line->uid.":".$UserDetail->uid;
                                                                    $query = "INSERT INTO ".TBL_PREFIX."_generated_user_commission SET uid='".$line->uid."',generated_comm_userid='".$generated_comm_userid."',generated_date=CURDATE()";
                                                                    $this->query($query);
                                                                }
							}
							for($j=$i;$j<=$i;$j++){  // for left leg commission count							
							$LeftId = $LeftfinalArr[$j];
								$UserDetail = $this->GetUserPackageDetail($LeftId);
								
								if($UserDetail->uid != $InactiveUserId){
									$packagePoint = isset($UserDetail->package_point) ? $UserDetail->package_point : 0;
                                                                        $CommStatus = $this->userCommissionStatus($line->uid);
                                                                if($this->numRows($CommStatus) > 0){
                                                                    while($record = $this->fetchNextObject($CommStatus)){
                                                                        $generatedUser = explode(':',$record->generated_comm_userid);
                                                                        if($UserDetail->uid != $generatedUser[1]){
                                                                            $Lcommission = $Lcommission +($packagePoint * $commissionConfig->point_value);
                                                                            $generated_comm_userid = $line->uid.":".$UserDetail->uid;
                                                                            $query = "INSERT INTO ".TBL_PREFIX."_generated_user_commission SET uid='".$line->uid."',generated_comm_userid='".$generated_comm_userid."',generated_date=CURDATE()";
                                                                            $this->query($query);
                                                                        }
                                                                    }
                                                                }else{
                                                                    $Lcommission = $Lcommission +($packagePoint * $commissionConfig->point_value);
                                                                    $generated_comm_userid = $line->uid.":".$UserDetail->uid;
                                                                    $query = "INSERT INTO ".TBL_PREFIX."_generated_user_commission SET uid='".$line->uid."',generated_comm_userid='".$generated_comm_userid."',generated_date=CURDATE()";
                                                                    $this->query($query);
                                                                }
									 
								}
								unset($temp[$j]);							
							}
						}
						$commissionVal = ($Rcommission + $Lcommission);
						// for direct income
                                                if(!empty($line->sponsor_id)){
                                                    $sponsorId = $line->sponsor_id;
                                                    $DirectIncomeUserId = $this->GenerateActualUserId($sponsorId);
                                                    $sponsorComm = $this->FetchPreviousUserCommission($DirectIncomeUserId);
                                                    if(!empty($sponsorComm)){
                                                        $ScommGeneDate = $sponsorComm->commissin_generate_date;
                                                        $dirIncome = (($commissionVal * $commissionConfig->direct_income)/100);
                                                        $query = "UPDATE ".TBL_PREFIX."_user_commission SET direct_income='".$dirIncome."' WHERE uid = '".$DirectIncomeUserId."' AND commissin_generate_date = $ScommGeneDate";
                                                        $this->query($query);
                                                    }
                                                }
						// for indirect income
                                                if(!empty($line->parent_id)){
                                                    $UserParentId = $line->parent_id;
                                                    $InDirectIncomeUserId = $this->GenerateActualUserId($UserParentId);
                                                    $ParentComm = $this->FetchPreviousUserCommission($InDirectIncomeUserId);
                                                    if(!empty($ParentComm)){
                                                        $PcommGeneDate = $ParentComm->commissin_generate_date;
                                                        $inDirIncome = (($commissionVal * $commissionConfig->indirect_income)/100);
                                                        $query = "UPDATE ".TBL_PREFIX."_user_commission SET indirect_income='".$inDirIncome."' WHERE uid = '".$InDirectIncomeUserId."' AND commissin_generate_date = $PcommGeneDate";
                                                        $this->query($query);
                                                    }
                                                }
						$LeftRemainingUserId = implode(',',$temp);						
						if(!empty($UserPackage->package_capping)){                                                    
                                                    if($commissionVal > $UserPackage->package_capping){
                                                        $commissionVal = $UserPackage->package_capping;
                                                    }
                                                }else{
                                                    $commissionVal = 0;
                                                }
						
						$query = "INSERT INTO ".TBL_PREFIX."_user_commission SET uid='".$line->uid."',commission_value=".$commissionVal.",direct_income=0,indirect_income=0,left_remaining_users='".$LeftRemainingUserId."' ,inactive_user_id='".$InactiveUserId."',commissin_generate_date=CURDATE()";
						$lastId = $this->lastInsertedId($this->query($query));
						
					}else{					
						$temp = $RightfinalArr; 						
						$Rcommission = 0;
						$Lcommission = 0;
						
						for($i=0;$i<$leftLeg;$i++){  //for left leg commission count							 
							
							$LeftId = $LeftfinalArr[$i];
								$UserDetail = $this->GetUserPackageDetail($LeftId);								
								if($UserDetail->uid != $InactiveUserId){
									$packagePoint = isset($UserDetail->package_point) ? $UserDetail->package_point : 0;
                                                                        $CommStatus = $this->userCommissionStatus($line->uid);
                                                                if($this->numRows($CommStatus) > 0){
                                                                    while($record = $this->fetchNextObject($CommStatus)){
                                                                       
                                                                        $generatedUser = explode(':',$record->generated_comm_userid);
                                                                        if($UserDetail->uid != $generatedUser[1]) {
                                                                            $Lcommission = $Lcommission + ($packagePoint * $commissionConfig->point_value);
                                                                            $generated_comm_userid = $line->uid . ":" . $UserDetail->uid;
                                                                            $query = "INSERT INTO " . TBL_PREFIX . "_generated_user_commission SET uid='" . $line->uid . "',generated_comm_userid='" . $generated_comm_userid . "',generated_date=CURDATE()";
                                                                            $this->query($query);
                                                                        }
                                                                        }
                                                                    } else {
                                                                         
                                                                        $Lcommission = $Lcommission + ($packagePoint * $commissionConfig->point_value);
                                                                        $generated_comm_userid = $line->uid . ":" . $UserDetail->uid;
                                                                        $query = "INSERT INTO " . TBL_PREFIX . "_generated_user_commission SET uid='" . $line->uid . "',generated_comm_userid='" . $generated_comm_userid . "',generated_date=CURDATE()";
                                                                        $this->query($query);
                                                                    }
                                                                }						
							
							for($j=$i;$j<=$i;$j++){  // for right leg commission count							
								$RightId = $RightfinalArr[$j];
								$UserDetail = $this->GetUserPackageDetail($RightId);
								
								if($UserDetail->uid != $InactiveUserId){
									$packagePoint = isset($UserDetail->package_point) ? $UserDetail->package_point : 0;								 	
                                                                        $CommStatus = $this->userCommissionStatus($line->uid);
                                                                        
                                                                        if($this->numRows($CommStatus) > 0){
                                                                            while($record = $this->fetchNextObject($CommStatus)){
                                                                                $generatedUser = explode(':',$record->generated_comm_userid);
                                                                                
                                                                                if($UserDetail->uid != $generatedUser[1]){                                                                                    
                                                                                    $Rcommission = $Rcommission +($packagePoint * $commissionConfig->point_value);
                                                                                    $generated_comm_userid = $line->uid.":".$UserDetail->uid;
                                                                                    $query = "INSERT INTO ".TBL_PREFIX."_generated_user_commission SET uid='".$line->uid."',generated_comm_userid='".$generated_comm_userid."',generated_date=CURDATE()";
                                                                                    $this->query($query);                                                                                   
                                                                                }
                                                                            }
                                                                        }else{                                                                            
                                                                            $Rcommission = $Rcommission +($packagePoint * $commissionConfig->point_value);
                                                                            $generated_comm_userid = $line->uid.":".$UserDetail->uid;
                                                                            $query = "INSERT INTO ".TBL_PREFIX."_generated_user_commission SET uid='".$line->uid."',generated_comm_userid='".$generated_comm_userid."',generated_date=CURDATE()";
                                                                            $this->query($query);
                                                                        }
								}
								unset($temp[$j]);							
							}
						}
						$commissionVal = ($Rcommission + $Lcommission);
						// for direct income
                                                if(!empty($line->sponsor_id)){
                                                    $sponsorId = $line->sponsor_id;
                                                    $DirectIncomeUserId = $this->GenerateActualUserId($sponsorId);
                                                    $sponsorComm = $this->FetchPreviousUserCommission($DirectIncomeUserId);
                                                    if(!empty($sponsorComm)){
                                                        $ScommGeneDate = $sponsorComm->commissin_generate_date;
                                                        $dirIncome = (($commissionVal * $commissionConfig->direct_income)/100);
                                                        $query = "UPDATE ".TBL_PREFIX."_user_commission SET direct_income='".$dirIncome."' WHERE uid = '".$DirectIncomeUserId."' AND commissin_generate_date = $ScommGeneDate";
                                                        $this->query($query);
                                                    }
                                                }
						// for indirect income
                                                if(!empty($line->parent_id)){
                                                    $UserParentId = $line->parent_id;
                                                    $InDirectIncomeUserId = $this->GenerateActualUserId($UserParentId);
                                                    $ParentComm = $this->FetchPreviousUserCommission($InDirectIncomeUserId);
                                                    if(!empty($ParentComm)){
                                                        $PcommGeneDate = $ParentComm->commissin_generate_date;
                                                        $inDirIncome = (($commissionVal * $commissionConfig->indirect_income)/100);						
                                                        $query = "UPDATE ".TBL_PREFIX."_user_commission SET indirect_income='".$inDirIncome."' WHERE uid = '".$InDirectIncomeUserId."' AND commissin_generate_date = $PcommGeneDate";
                                                        $this->query($query);
                                                    }
                                                }
						$RightRemainingUserId = implode(',',$temp);
                                                if(!empty($UserPackage->package_capping)){                                                    
                                                    if($commissionVal > $UserPackage->package_capping){
                                                        $commissionVal = $UserPackage->package_capping;
                                                    }
                                                }else{
                                                    $commissionVal = 0;
                                                }
                                                
						//$commissionVal = $commissionVal - ($dirIncome + $inDirIncome);
						
						$query = "INSERT INTO ".TBL_PREFIX."_user_commission SET uid='".$line->uid."',commission_value=".$commissionVal.",direct_income=0,indirect_income=0,right_remaining_users='".$RightRemainingUserId."' ,inactive_user_id='".$InactiveUserId."',commissin_generate_date=CURDATE()";
						$lastId = $this->lastInsertedId($this->query($query));
						
					}
					
						
						
						
				}
		}
	}
        function userCommissionStatus($id){
           $query = "SELECT * FROM ".TBL_PREFIX."_generated_user_commission where uid = '".$id."'";
		$result = $this->query($query); 
                return $result;
        }
	function GenerateActualUserId($userId){
		$del="SM100";
		$pos=strpos($userId, $del);
		$id=substr($userId, $pos+strlen($del)-0, strlen($userId)-0);
		return $id;
	}
	function FetchPreviousUserCommission($id){ 
		$query = "SELECT * FROM ".TBL_PREFIX."_user_commission where uid = '".$id."' ORDER BY cid DESC LIMIT 1";
		$result = $this->query($query);
		$line = $this->fetchNextObject($result);
		return $line;
	}
	function getCommissionConfig(){
		$adminArr = $this->query("select * from ".TBL_PREFIX."_commission_setting where id=1");
		$rows = $this->numRows($adminArr);
		if($rows>0){
			$qr=$this->fetchNextObject($adminArr);
			return $qr;
		} 
	}
	function getTotalLegRightUserId($memid,$leg){
  		 $sql="select * from ".TBL_PREFIX."_users where parent_id='".$memid."' and position='".$leg."'";    
  			$res=$this->query($sql);  
  			
  			$row=$this->fetchNextObject($res);
			if(!empty($row->uid)){
 			self::$value2  .= $row->uid.","; 
			 if($row->uid !=''){
			 	$uid = 'SM100'.$row->uid;
			   $this->getTotalLegRightUserId($uid,'1');
			   $this->getTotalLegRightUserId($uid,'2');
			  }
			}
    		return self::$value2;
    }
	function getTotalLegLeftUserId($memid,$leg){
  		 $sql="select * from ".TBL_PREFIX."_users where parent_id='".$memid."' and position='".$leg."'";    
  			$res=$this->query($sql);  
  			
  			$row=$this->fetchNextObject($res);
			if(!empty($row->uid)){
 			self::$leftArr  .= $row->uid.","; 
			 if($row->uid !=''){
			 	$uid = 'SM100'.$row->uid;
			   $this->getTotalLegLeftUserId ($uid,'1');
			   $this->getTotalLegLeftUserId ($uid,'2');
			  }
			}
    		return self::$leftArr;
    }
	function FindInactiveUserId($str){
	 $qry = "SELECT uid FROM ".TBL_PREFIX."_users WHERE uid IN ($str) ORDER BY DATE(created) ASC , TIME(created) ASC limit 1";
	$result = $this->query($qry);
	$line = $this->fetchNextObject($result);
	return $line->uid;
	}
	function UpdateUserRPWallet($value){
		$id = $_SESSION['UID'];		
  		$query = "SELECT * FROM ".TBL_PREFIX."_wallet where uid='".$id."'";
    	$result = $this->query($query);
		
		if($this->numRows($result) > 0){
			$query = "UPDATE ".TBL_PREFIX."_wallet SET right_rp_value=".$value['rightRPVal'].",left_rp_value=".$value['leftRPVal'].",updated=NOW() WHERE uid='".$id."'";
		}else{
				$query = "INSERT INTO ".TBL_PREFIX."_wallet SET uid=$id,right_rp_value=".$value['rightRPVal'].",left_rp_value=".$value['leftRPVal']." ,status=1,created=NOW()";
			}		
		$this->query($query);
	}
	function getUserRPValue($UserChild){
	$Arr = array();
	$rightUser = $rightRPVal = $leftUser = $leftRPVal = $recharge = 0;	 
	if(!empty($UserChild)){
	
		if(!empty($UserChild['RightUser'])){
		$RightVal = $this->CalculateRPValue(0,$UserChild['RightUser']);
		
			if(!empty($RightVal)){
				$rightUser = $RightVal['users'];
				$rightRPVal = $RightVal['rpvalu'];
			}else{
				$rightUser = 0;
				$rightRPVal = 0;
			}
		}else{
			$rightUser = 0;
			$rightRPVal = 0;
		}	
		if(!empty($UserChild['LeftUser'])){
			$LeftUser = $this->CalculateRPValue(0,$UserChild['LeftUser']);
			
				if(!empty($LeftUser)){
					$leftUser = ($LeftUser['users'] - $rightUser);
					$leftRPVal = ($LeftUser['rpvalu'] - $rightRPVal);
				}else{
					
				}
		}else{
			$leftUser = 0;
			$leftRPVal = 0;
		}	
	  }
	  $Arr = array(
	  	'rightUser'  =>$rightUser,
	  	'rightRPVal' =>number_format($rightRPVal,2),
	  	'leftUser'   =>$leftUser,
	  	'leftRPVal'  =>number_format($leftRPVal,2)
 	  );
	  return $Arr;
	}
	function rechargeAmt($id){
		$query = "SELECT * FROM ".TBL_PREFIX."_wallet where uid='".$id."'";
		if($this->numRows($this->query($query)) > 0)
    		{				
				 $line = $this->fetchNextObject($this->query($query));
				 $amt = number_format($line->wallet_value,2);
				 return $amt;
			}else{
				return $amt= '0.00';
			}
	}
	function CalculateRPValue($val, $parentID=null)
	{ 		
		static $val;
		static $users;
		// Create the query
		$sql = "SELECT * FROM ".TBL_PREFIX."_users WHERE ";
		if($parentID == null) {
			$sql .= "parent_id IS NULL";
		}
		else {
			$sql .= "parent_id = '$parentID'";
		}
			
		$del="SM100";
		$pos=strpos($parentID, $del);
		$id=substr($parentID, $pos+strlen($del)-0, strlen($parentID)-0);
		
		$packages = $this->GetUserPackageDetail($id);
		if(!empty($packages->package_rp)){
			$val = $val + $packages->package_rp;
			++self::$RPVal;
		}
		// Execute the query and go through the results.
		$result = $this->query($sql);
		if($result)
		{
			while($line = $this->fetchNextObject($result))
			{
				
				// Print the current ID;
				$currentID = 'SM100'.$line->uid;
				
				$this->CalculateRPValue($val, $currentID);
			}			
		}
		else
		{
			die("Failed to execute query! ( $parentID)");
		}
		return array(
		'rpvalu'=>$val,
		'users'=>self::$RPVal
		);
	}
	
	function GetUserPackageDetail($id){
		$sql = "SELECT * FROM ".TBL_PREFIX."_users WHERE ";
		if($id == null) {
			$sql .= "uid IS NULL";
		}
		else {
			$sql .= "uid='$id'";
		}	
		//Execute the query and go through the results.
		$result = $this->query($sql);
                $line = $this->fetchNextObject($result);
		if($line)
		{	
			if($line->user_pin){
				$sql = "SELECT * FROM ".TBL_PREFIX."_tokens as t LEFT JOIN tbl_packages AS p ON t.pid = p.pid LEFT JOIN tbl_users AS u ON u.user_pin = t.token WHERE token = '".$line->user_pin."' ";
				$row = $this->fetchNextObject($this->query($sql));
				return $row;				
			}else{
                            return $line;
                        }
		}
                
	}
	function ChildNode($id)
	{
		$query = "SELECT * FROM ".TBL_PREFIX."_users where parent_id='".$id."' LIMIT 2";
    	$check_parent_node = $this->query($query);
		
    	if($this->numRows($check_parent_node) > 0)
    		{				
				 while($line = $this->fetchNextObject($check_parent_node))
				{	if($line->position == '2')
					{
						$posts['children']= array('name'=>$line->username);
						
					}
					else
					{
					$posts['children']= array('name'=>$line->username);
						
					}
					$this->ChildNode('SM100'.$line->uid);
					
				}
        		

    		}
	}
	
	function CreateInnerChild($val=array(), $parentID=null)
	{ 	
		// Create the query
		$sql = "SELECT * FROM ".TBL_PREFIX."_users WHERE ";
		if($parentID == null) {
			$sql .= "parent_id IS NULL";
		}
		else {
			$sql .= "parent_id = '$parentID'";
		}
	
		$del="SM100";
		$pos=strpos($parentID, $del);
		$id=substr($parentID, $pos+strlen($del)-0, strlen($parentID)-0);
		
		// Execute the query and go through the results.
		$result = $this->query($sql);
		if($result)
		{
			while($line = $this->fetchNextObject($result))
			{
				
				// Print the current ID;
				$currentID = 'SM100'.$line->uid;
				
				$Userd = $this->GetUser($line->uid);
				$val[] = array(
				'name' =>$Userd->username,
				'title'=>"Name = $Userd->username , User Id = SM100$line->uid , Sponsor Id = $line->sponsor_id",
				'children' => $this->CreateInnerChild(NULL, $currentID)
				);
				
			}			
		}
		else
		{
			die("Failed to execute query! ( $parentID)");
		}
		return $val;
		
	}
	
	function CreateBTreePosition($id){
	$userData = $this->getUser($_SESSION['UID']);
		$response = array();
		$Arr = array();
		$posts['name']= $userData->username; 
		$posts['title'] ="Name = $userData->username , User Id = SM100$userData->uid , Sponsor Id = $userData->sponsor_id";
  		$query = "SELECT * FROM ".TBL_PREFIX."_users where parent_id='".$id."' LIMIT 2";
    	$check_parent_node = $this->query($query);
		
    	if($this->numRows($check_parent_node) > 0)
    		{				
				 while($line = $this->fetchNextObject($check_parent_node))
				{	
				
				if($line->position == '2')
					{
						$posts['children'][] = array(
						'name'=>$line->username,
						'title'=>"Name = $line->username , User Id = SM100$line->uid , Sponsor Id = $line->sponsor_id",
						'children'=>$this->CreateInnerChild($Arr,'SM100'.$line->uid)
						);
						
					}
					else
					{
					$posts['children'][] = array(
						'name'=>$line->username,
						'title'=>"Name = $line->username , User Id = SM100$line->uid , Sponsor Id = $line->sponsor_id",
						'children'=>$this->CreateInnerChild($Arr,'SM100'.$line->uid)
						);
						
					}
					//$this->ChildNode('SM100'.$line->uid);
				}
    		}else{
				$posts['children'][] = array();
			}
			//echo '<pre>';
			//print_r($posts);
			//echo '</pre>';die;
					
					$json = json_encode($posts);
					$userId = $_SESSION['UID'];
					$path = "script/".$userId."/";					
					$file = $path.'file.json';
					file_put_contents($file, $json);
	}
	
	function validateUserLogin(){
   
		if(($_SESSION['UID'] == null )&&($_SESSION['UNAME'] == null )) {
		
			$this->commonObjContent->wtRedirect("index.php"); 
		} 
	}
	
	function UpdateUserProfile($params,$img=null){
		$this->query("UPDATE ".TBL_PREFIX."_users SET username='".$this->commonObjContent->praseData($params['username'])."',address='".$this->commonObjContent->praseData($params['address'])."',mobile='".$this->commonObjContent->praseData($params['mobile'])."',profile_image='".$this->commonObjContent->praseData($img)."',acct_holder_name='".$this->commonObjContent->praseData($params['acct_holder_name'])."',pancard='".$this->commonObjContent->praseData($params['pancard'])."',city='".$this->commonObjContent->praseData($params['city'])."',state='".$this->commonObjContent->praseData($params['state'])."',country='".$this->commonObjContent->praseData($params['country'])."',bank_name='".$this->commonObjContent->praseData($params['bank_name'])."',acct_number='".$this->commonObjContent->praseData($params['acct_number'])."',branch_code='".$this->commonObjContent->praseData($params['branch_code'])."',updated=NOW() WHERE uid = '".intval($_SESSION['UID'])."'");
		$this->commonObjContent->pushMessage("Profile has been changed successfully.");
		//$this->commonObjContent->wtRedirect("package.php");
	}
	function ChangeUserPin($params){
	 	
		$qr = "SELECT * FROM ".TBL_PREFIX."_tokens where token='".$this->commonObjContent->praseData($params['user_pin'])."'";
		$QryRs =$this->query($qr);
		if($this->numRows($QryRs)==0) {
			$this->commonObjContent->pushError("Invalid pin enter by user.");
		}else{		
		$query = "SELECT * FROM ".TBL_PREFIX."_users where user_pin='".$this->commonObjContent->praseData($params['user_pin'])."'";
		$QryRs =$this->query($query);
		if($this->numRows($QryRs)==0) {
			$this->query("UPDATE ".TBL_PREFIX."_users SET user_pin='".$this->commonObjContent->praseData($params['user_pin'])."',updated=NOW()  where uid = '".intval($_SESSION['UID'])."'");
		$token = $this->commonObjContent->praseData($params['user_pin']);
		$this->query("update ".TBL_PREFIX."_tokens set status=0 where token='".$token."'");					
		$this->commonObjContent->pushMessage("Package has been changed successfully.");
		$this->commonObjContent->wtRedirect("package.php");
		}else{
			$this->commonObjContent->pushMessage("Pin already assign to another.");						
			$this->commonObjContent->wtRedirect("update_package.php?pid=".$params['pid']);
		  }			
		}
	}
	
	function updateUser($params,$PASS)
	{	
		if(empty($params['user_pin'])){
			$this->query("update ".TBL_PREFIX."_users set username='".$this->commonObjContent->praseData($params['username'])."',parent_id='".$this->commonObjContent->praseData($params['parent_id'])."',email='".$this->commonObjContent->praseData($params['email'])."',password='".$PASS."',position='".$this->commonObjContent->praseData($params['position'])."',sponsor_id='".$this->commonObjContent->praseData($params['sponsor_id'])."',address='".$this->commonObjContent->praseData($params['address'])."',mobile='".$this->commonObjContent->praseData($params['mobile'])."',user_pin = '".$this->commonObjContent->praseData($params['user_pin'])."',status = 0,date_of_birth='".$this->commonObjContent->praseData($params['date_of_birth'])."',updated=NOW()  where uid = '".intval($params['uid'])."'");
		}else{
		$userD = $this->getUser($params['uid']);
		if($userD->user_pin != $params['user_pin']){	
			$rs = $this->query("SELECT * FROM ".TBL_PREFIX."_tokens WHERE token='".$params['user_pin']."'");
			if($this->numRows($rs) > 0){
				$res = $this->fetchNextObject($rs);
				if($rs->status == 1){					
			$this->query("update ".TBL_PREFIX."_users set username='".$this->commonObjContent->praseData($params['username'])."',parent_id='".$this->commonObjContent->praseData($params['parent_id'])."',email='".$this->commonObjContent->praseData($params['email'])."',password='".$PASS."',position='".$this->commonObjContent->praseData($params['position'])."',sponsor_id='".$this->commonObjContent->praseData($params['sponsor_id'])."',address='".$this->commonObjContent->praseData($params['address'])."',mobile='".$this->commonObjContent->praseData($params['mobile'])."',user_pin = '".$this->commonObjContent->praseData($params['user_pin'])."',status = 1 ,date_of_birth='".$this->commonObjContent->praseData($params['date_of_birth'])."',updated=NOW()  where uid = '".intval($params['uid'])."'");	
		$token = $this->commonObjContent->praseData($params['user_pin']);
		$this->query("update ".TBL_PREFIX."_tokens set status=0 where token='".$token."'");					
		}else{
				$this->commonObjContent->pushError('Pin already assign to another. Try again with diffrent Pin.');
				$this->commonObjContent->wtRedirect("add_user.php?uid=".$params['uid']);
			}
		}else{
			$this->commonObjContent->pushError('Please enter valid pin.');
			$this->commonObjContent->wtRedirect("add_user.php?uid=".$params['uid']);
		}
	}else{
	$this->query("update ".TBL_PREFIX."_users set username='".$this->commonObjContent->praseData($params['username'])."',parent_id='".$this->commonObjContent->praseData($params['parent_id'])."',email='".$this->commonObjContent->praseData($params['email'])."',password='".$PASS."',position='".$this->commonObjContent->praseData($params['position'])."',sponsor_id='".$this->commonObjContent->praseData($params['sponsor_id'])."',address='".$this->commonObjContent->praseData($params['address'])."',mobile='".$this->commonObjContent->praseData($params['mobile'])."',date_of_birth='".$this->commonObjContent->praseData($params['date_of_birth'])."',updated=NOW()  where uid = '".intval($params['uid'])."'");	
	
	$this->commonObjContent->pushMessage("User updated successfully.");
	$this->commonObjContent->wtRedirect("user.php");
	}
}	
	
	}
	function forgetPassword($uid){		
			if (strpos($uid,'SM100') !== false) {
				$del="SM100";
				$pos=strpos($uid, $del);
				$id=substr($uid, $pos+strlen($del)-0, strlen($uid)-0);
				$qry = "SELECT * FROM ".TBL_PREFIX."_users where uid = '".$id."' ";
				$row = $this->query($qry);
				if($this->NumRows($row) > 0){
					$line = $this->fetchNextObject($row);
					$smsMsg = "Your password : ".$this->encryObj->decode($line->password);	
                	// send msg api intregration   
                	$this->SendMsgToUser($line->mobile,$smsMsg);
					$this->commonObjContent->pushMessage("Your passwrod sent to your mobile device.");

				}
    			}else{
					$this->commonObjContent->pushError("Invalid user Id.");	
				}
		
		
	}
	function getUserPackage($UserPin){	
	$record = '';
	$qry = "SELECT * FROM `tbl_tokens` AS token LEFT JOIN tbl_packages AS package ON token.pid = package.pid WHERE token.token = '".$UserPin."'";
		$row = $this->query($qry);
		if($this->NumRows($row) > 0){
			$record = $this->fetchNextObject($row);
		}
		
		return $record;
	}
	
	function getTreePosition($sponsorId){
	$Right = 0;
	$Left  = 0;
	$result = array();
	$qry = "SELECT * FROM ".TBL_PREFIX."_users where parent_id = '".$sponsorId."' ";
		$row = $this->query($qry);
		if($this->NumRows($row) > 0){
			while($record = $this->fetchNextObject($row)){
				if($record->position == 1){
				$Right++;	
				}
				if($record->position == 2){
					$Left++;
				}
			}
		}
		$result = array(
			'Right' => $Right,
			'Left'  => $Left,
			'String' => 'Right Position = '.$Right.' Left Position = '.$Left
		);
		return $result;
	}
	function AddUser($params,$PASS,$from=null){	
            
            $parentId = $this->GenerateActualUserId($this->commonObjContent->praseData($params['parent_id']));
            $query = "SELECT * FROM ".TBL_PREFIX."_users where uid = '".$parentId."'";
		$QryRs =$this->query($query);
		if($this->numRows($QryRs) == 0) {
                  $this->commonObjContent->pushError("Invalid Parent Id.");
                    if ($from == 'front') {
                        $this->commonObjContent->wtRedirect("register.php");
                    } else {
                        $this->commonObjContent->wtRedirect("add_user.php");
                    }  
                }
                
         $sponsor_id = $this->GenerateActualUserId($this->commonObjContent->praseData($params['sponsor_id']));
            $query = "SELECT * FROM ".TBL_PREFIX."_users where uid = '".$sponsor_id."'";
		$QryRs =$this->query($query);
		if($this->numRows($QryRs) == 0) {
                  $this->commonObjContent->pushError("Invalid Sponsor Id.");
                    if ($from == 'front') {
                        $this->commonObjContent->wtRedirect("register.php");
                    } else {
                        $this->commonObjContent->wtRedirect("add_user.php");
                    }  
                }   
        if(!empty($params['user_pin'])){
	$query = "SELECT * FROM ".TBL_PREFIX."_tokens where token = '".$this->commonObjContent->praseData($params['user_pin'])."' AND (status = 1 OR status = 2)";
		$QryRs =$this->query($query);
		if($this->numRows($QryRs) > 0) {
		$Str = $this->commonObjContent->praseData($params['parent_id']);			
			if (strpos($Str,'SM100') !== false) {
    			$UserPos = $this->getUserPosition($this->commonObjContent->praseData($params['parent_id']),$this->commonObjContent->praseData($params['position']));
				if($UserPos){
					$this->query("INSERT INTO ".TBL_PREFIX."_users set user_pin='".$this->commonObjContent->praseData($params['user_pin'])."',parent_id='".$this->commonObjContent->praseData($params['parent_id'])."',username='".$this->commonObjContent->praseData($params['username'])."',email='".$this->commonObjContent->praseData($params['email'])."',password='".$PASS."',position='".$this->commonObjContent->praseData($params['position'])."',sponsor_id='".$this->commonObjContent->praseData($params['sponsor_id'])."',address='".$this->commonObjContent->praseData($params['address'])."',mobile='".$this->commonObjContent->praseData($params['mobile'])."',date_of_birth='".$this->commonObjContent->praseData($params['date_of_birth'])."',created=CURDATE(),status=1");
		$token = $this->commonObjContent->praseData($params['user_pin']);
		$userId = mysql_insert_id();
		$this->query("update ".TBL_PREFIX."_tokens set status=0 where token='".$token."'");	
		$smsMsg = "Your User Pin : SM100".$userId." and Password : ".$params['password'];	
                // send msg api intregration   
                $this->SendMsgToUser($params['mobile'],$smsMsg);
            $msg = "Congratulation ".$this->commonObjContent->praseData($params['username']).",<br> Registration has been successfully. Your User pin is : SM100".$userId.". Remember it for further.";
                
			$this->commonObjContent->pushMessage($msg);						
	
				}else{
						$UserMsg = '';
						if($params['position'] == 1){
							$UserMsg = "Parent's right position already filled out.";
						}else{
							$UserMsg = "Parent's left position already filled out.";
						}
						$this->commonObjContent->pushError($UserMsg);
					if($from == 'front'){		
						$this->commonObjContent->wtRedirect("register.php");
					}else{			
						$this->commonObjContent->wtRedirect("add_user.php");
					}
				}	
			}else{
				$this->commonObjContent->pushError("Invalid Parent Id.");
				if($from == 'front'){		
					$this->commonObjContent->wtRedirect("register.php");
				}else{			
					$this->commonObjContent->wtRedirect("add_user.php");
				}
			}
		}else{
			$this->commonObjContent->pushError("Invalid Pin");						
			if($from == 'front'){		
				$this->commonObjContent->wtRedirect("register.php");
			}else{			
				$this->commonObjContent->wtRedirect("add_user.php");
			}
		  }	
		}else{
		
			$Str = $this->commonObjContent->praseData($params['parent_id']);			
			if (strpos($Str,'SM100') !== false) {
    			$UserPos = $this->getUserPosition($this->commonObjContent->praseData($params['parent_id']),$this->commonObjContent->praseData($params['position']));
				if($UserPos){
			
			$this->query("INSERT INTO ".TBL_PREFIX."_users set parent_id='".$this->commonObjContent->praseData($params['parent_id'])."',username='".$this->commonObjContent->praseData($params['username'])."',email='".$this->commonObjContent->praseData($params['email'])."',password='".$PASS."',position='".$this->commonObjContent->praseData($params['position'])."',sponsor_id='".$this->commonObjContent->praseData($params['sponsor_id'])."',address='".$this->commonObjContent->praseData($params['address'])."',mobile='".$this->commonObjContent->praseData($params['mobile'])."',date_of_birth='".$this->commonObjContent->praseData($params['date_of_birth'])."',created=CURDATE()");
		$userId = mysql_insert_id();
		//$this->commonObjContent->pushMessage("User added successfully.");			
			}else{
						$UserMsg = '';
						if($params['position'] == 1){
							$UserMsg = "Parent's right position already filled out.";
						}else{
							$UserMsg = "Parent's left position already filled out.";
						}
						$this->commonObjContent->pushError($UserMsg);
					if($from == 'front'){		
						$this->commonObjContent->wtRedirect("register.php");
					}else{			
						$this->commonObjContent->wtRedirect("add_user.php");
					}
				}
		}else{
				$this->commonObjContent->pushError("Invalid Parent Id.");
				if($from == 'front'){		
					$this->commonObjContent->wtRedirect("register.php");
				}else{			
					$this->commonObjContent->wtRedirect("add_user.php");
				}
			}
		
			if($from == 'front'){		
			$msg = "Congratulation ".$this->commonObjContent->praseData($params['username']).",<br> Registration has been successfully. Your User pin is : SM100".$userId.". Remember it for further.";
			// send msg api intregration 
				$smsMsg = "Your User Pin : SM100".$userId." and Password : ".$params['password'];	
                // send msg api intregration   
                $this->SendMsgToUser($params['mobile'],$smsMsg);
				$this->commonObjContent->pushMessage($msg);
				$this->commonObjContent->wtRedirect("register.php");
			}else{			
				$this->commonObjContent->wtRedirect("user.php");
			}
		}	
	}
        
function SendMsgToUser($mob,$smsMsg){
            $url = "http://sms.sasquare.in/api/sendmsg.php";
   
            $data = array (
              'user' => '8923604624',
              'pass' => '8923604624',
              'sender' => 'SMMPVL',
              'phone' => "$mob",
              'text' => "$smsMsg",
              'priority' => 'sdnd',
              'stype' => 'normal'
             );
       
              $params = '';
              foreach($data as $key=>$value)
               $params .= $key.'='.$value.'&';
               $params = rtrim($params, '&');
               $ch = curl_init();
       		curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_URL, $url); //Remote Location URL
    
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
            curl_setopt($ch, CURLOPT_HEADER, 0);
            //We add these 2 lines to create POST request
            curl_setopt($ch, CURLOPT_POST, count($data)); //number of parameters sent
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params); //parameters data
            $result = curl_exec($ch);
       		//curl_errno($ch)
            curl_close($ch);
        }

	function getUserPosition($parentId,$position){
		$result = '';
		$q = $this->query("select * from ".TBL_PREFIX."_users where parent_id='$parentId' AND position ='$position'");
		$qr = $this->numRows($q);
		if($qr == 0){
			$result = 1;
		}else{
			$result = 0;
		}
		return $result;
	}	
	function statusRemove($id){
		$q=$this->query("update ".TBL_PREFIX."_users set status = 2, updated = NOW()  where uid=$id");
		$this->commonObjContent->pushMessage("User has been removed successfully.");
		$this->commonObjContent->wtRedirect("user.php");	
	}
	
	function getUser($id){
		$q=$this->query("select * from ".TBL_PREFIX."_users where uid='$id' OR user_pin ='$id'");
		$qr=$this->fetchNextObject($q);
		return $qr;
	}
	function getUserChild($id){
	    $result = array();
		$q=$this->query("select * from ".TBL_PREFIX."_users where parent_id='$id'");
		while($qr = $this->fetchNextObject($q)){
			if($qr->position == 1){
				$result['RightUser'] = 'SM100'.$qr->uid;
			}
			else{
				$result['LeftUser'] = 'SM100'.$qr->uid;
			}
		}
		return $result;
	}
	function getMyWallet(){
		$q=$this->query("select * from ".TBL_PREFIX."_user_commission where request_payment = 0 AND uid='".$_SESSION['UID']."'");
		return $q;
	}
	function getUserWallet($params){
	$searchQ = '';
	$sortby = 'DESC';
	$col = 'cid';
	
	if (isset($params['sort'])) {  
  		$sortby = $params['sort'];
	}
	if (isset($params['column'])) {  
  		$col = $params['column'];
	}
  	$start=0;
	$limit=10;

	if(isset($params['page']))
	{
	$id = $params['page'];
	$start=($id-1)*$limit;
	}
	//echo "select * from ".TBL_PREFIX."_user_commission where uid='".$_SESSION['UID']."' ORDER BY $col $sortby LIMIT $start, $limit";
		$q=$this->query("select * from ".TBL_PREFIX."_user_commission where request_payment = 0 AND uid='".$_SESSION['UID']."' ORDER BY $col $sortby LIMIT $start, $limit");		
		return $q;
	}
	
	
	function getMyCommission(){
		$q=$this->query("select * from ".TBL_PREFIX."_user_commission where uid='".$_SESSION['UID']."'");
		return $q;
	}
	function getUserCommission($params){
	$searchQ = '';
	$sortby = 'DESC';
	$col = 'cid';
	
	if (isset($params['sort'])) {  
  		$sortby = $params['sort'];
	}
	if (isset($params['column'])) {  
  		$col = $params['column'];
	}
  	$start=0;
	$limit=10;

	if(isset($params['page']))
	{
	$id = $params['page'];
	$start=($id-1)*$limit;
	}
	//echo "select * from ".TBL_PREFIX."_user_commission where uid='".$_SESSION['UID']."' ORDER BY $col $sortby LIMIT $start, $limit";
		$q=$this->query("select * from ".TBL_PREFIX."_user_commission where uid='".$_SESSION['UID']."' ORDER BY $col $sortby LIMIT $start, $limit");		
		return $q;
	}
	function getAdminTransaction(){
		$q=$this->query("select * from ".TBL_PREFIX."_user_payment_request where  1=1");
		return $q;
	}
	
	function getAdminAllTransaction($params){ 
	$searchQ = '';
	$sortby = 'DESC';
	$col = 'rid';
	if (!empty($params['searchQry'])) {  
		$UserId = $this->GenerateActualUserId($params['searchQry']);
  		$searchQ = " AND uid = '$UserId'";		
	}
	if (isset($params['sort'])) {  
  		$sortby = $params['sort'];
	}
	if (isset($params['column'])) {  
  		$col = $params['column'];
	}
  	$start=0;
	$limit=10;

	if(isset($params['page']))
	{
	$id = $params['page'];
	$start=($id-1)*$limit;
	}
	//echo "select * from ".TBL_PREFIX."_user_commission where 1=1 $searchQ ORDER BY $col $sortby LIMIT $start, $limit";
		$q=$this->query("select * from ".TBL_PREFIX."_user_payment_request where 1=1 $searchQ ORDER BY $col $sortby LIMIT $start, $limit");		
		return $q;
	}
	
	function getMyTransaction(){
		$q=$this->query("select * from ".TBL_PREFIX."_user_payment_request where  uid='".$_SESSION['UID']."'");
		return $q;
	}
	function getUserTransaction($params){ 
	$searchQ = '';
	$sortby = 'DESC';
	$col = 'rid';
	if (isset($params['searchQry'])) {  
		$UserId = $this->GenerateActualUserId($params['searchQry']);
  		$searchQ = " AND uid = '$UserId'";		
	}
	if (isset($params['sort'])) {  
  		$sortby = $params['sort'];
	}
	if (isset($params['column'])) {  
  		$col = $params['column'];
	}
  	$start=0;
	$limit=10;

	if(isset($params['page']))
	{
	$id = $params['page'];
	$start=($id-1)*$limit;
	}
	//echo "select * from ".TBL_PREFIX."_user_commission where uid='".$_SESSION['UID']."' ORDER BY $col $sortby LIMIT $start, $limit";
		$q=$this->query("select * from ".TBL_PREFIX."_user_payment_request where uid='".$_SESSION['UID']."' $searchQ ORDER BY $col $sortby LIMIT $start, $limit");		
		return $q;
	}
	
	
	function getUserByPin($id){
		$q=$this->query("select * from ".TBL_PREFIX."_users where  user_pin ='$id'");
		$qr=$this->fetchNextObject($q);
		return $qr;
	}
	function getUserByFullId($id){
		$UserId = $this->GenerateActualUserId($id);
		$q=$this->query("select * from ".TBL_PREFIX."_users where  uid ='$UserId'");
		$qr=$this->fetchNextObject($q);
		return $qr;
	}
	function changePassword($old_password,$new_password){
		$Arr  = $this->query("select * from ".TBL_PREFIX."_users where password = '$old_password' and uid=".$_SESSION['UID'],$debug=-1);
		$rows = $this->numRows($Arr);
		if($rows > 0){
		$this->query("update ".TBL_PREFIX."_users set password = '$new_password' where uid=".$_SESSION['UID']);
		$this->commonObjContent->pushMessage("Password changed sucessfully.");		
		} else {
			$this->commonObjContent->pushError("Old password is wrong.");
		}
	}
	function fetchAllUsers(){
		$q=$this->query("select * from ".TBL_PREFIX."_users where 1 = 1");
		return $q;
	}
	function fetchAllAssignedUsersPin($uid){
		$q=$this->query("select * from ".TBL_PREFIX."_tokens where assign_to_user = $uid");
		return $q;
	}
	function fetchAll($params){
	$searchQ = '';
	$sortby = 'ASC';
	$col = 'uid';
	if (isset($params['searchQry'])) {  
		$UserId = $this->GenerateActualUserId($params['searchQry']);
  		$searchQ = " AND (username LIKE '%".$params['searchQry']."%' OR uid = '$UserId')";
		
	}
	if (isset($params['sort'])) {  
  		$sortby = $params['sort'];
	}
	if (isset($params['column'])) {  
  		$col = $params['column'];
	}
  	$start=0;
	$limit=10;

	if(isset($params['page']))
	{
	$id = $params['page'];
	$start=($id-1)*$limit;
	}
	//echo "select * from ".TBL_PREFIX."_users where status != 2  ORDER BY $col $sortby LIMIT $start, $limit";
		$q=$this->query("select * from ".TBL_PREFIX."_users where status != 2 $searchQ ORDER BY $col $sortby LIMIT $start, $limit");
		return $q;
	}
	
	function AssignedUsersPin($params,$front = null){
	if($front == 'front'){
	$uid = intval($_SESSION['UID']);
	}else{
	$uid = intval($params['uid']);
	}
	$searchQ = '';
	$sortby = 'ASC';
	$col = 'tid';
	if (isset($params['searchQry'])) {  
  		$searchQ = " AND username LIKE '%".$params['searchQry']."%'";
		
	}
	if (isset($params['sort'])) {  
  		$sortby = $params['sort'];
	}
	if (isset($params['column'])) {  
  		$col = $params['column'];
	}
  	$start=0;
	$limit=10;

	if(isset($params['page']))
	{
	$id = $params['page'];
	$start=($id-1)*$limit;
	}
	//echo "select * from ".TBL_PREFIX."_users where status != 2  ORDER BY $col $sortby LIMIT $start, $limit";
		$q=$this->query("select * from ".TBL_PREFIX."_tokens where assign_to_user = ".$uid." $searchQ ORDER BY $col $sortby LIMIT $start, $limit");
		return $q;
	}
	function RequestPayment($param){
		$userD = $this->getUser($param['uid']);
		$qry = "INSERT INTO ".TBL_PREFIX."_user_payment_request SET `uid` = '".$param['uid']."',`request_value` = '".$param['request_value']."', `request_date` = CURDATE()";
		$requestId = $this->lastInsertedId($this->query($qry));
		$query = "UPDATE ".TBL_PREFIX."_user_commission set `request_payment` = 1,`request_date` = NOW() WHERE uid=".intval($param['uid']);
		$this->query($query);
		$smsMsg = "Your payment request has been sent successfully. Your Request Id : #".$userD->user_pin.$requestId;
		$this->SendMsgToUser($userD->mobile,$smsMsg);
		$this->commonObjContent->pushMessage($smsMsg);		
		$this->commonObjContent->wtRedirect("transaction-history.php");
	}
	function getUserWalletDetails($id){
		$Arr = array();
		$total = 0;
		$dir = $indir = 0;
		$query = "SELECT * FROM ".TBL_PREFIX."_user_commission where `uid`='".intval($id)."' AND `request_payment` = '0'";
		$query = $this->query($query);
		if($this->numRows($query)> 0){
			while($line = $this->fetchNextObject($query)){
				$total = $total + $line->commission_value;
				$dir   = $dir + $line->direct_income;
				$indir = $indir + $line->indirect_income;
			}
		}
		$Arr = array(
			'Commission'=>$total,
			'Direct'=>$dir,
			'Indirect'=>$indir,
		);
		return $Arr;
	}	
	function modifyStatus($params){
	
	$userData = $this->getUser($_POST['uid']);
	if($userData->user_pin == ''){
		$this->commonObjContent->pushError("You need to assign user pin before processing.");
		return('success');
		//
	}else{
		if($this->commonObjContent->praseData($_POST['action']) == 'active'){
			$val = 1;
		}else{
			$val = 0;
		}
			$query = "update ".TBL_PREFIX."_users set status =".$val.",updated = NOW() where uid=".intval($_POST['uid']);
			$q = $this->query($query);
			if($q){
				return('success');
			}else{
				return('fail');
			}
		}	
	}
	
	function login($id,$password){			
		$del="SM100";
		$pos=strpos($id, $del);
		$id=substr($id, $pos+strlen($del)-0, strlen($id)-0);

		$query = "SELECT * FROM ".TBL_PREFIX."_users where uid='".$id."' and password='".$password."'";
		$loginRs =$this->query($query,-1);
		if($this->numRows($loginRs)==0) {
			$this->commonObjContent->pushError('Invalid login');
			$this->commonObjContent->wtRedirect("login.php");
		} else {		
			$loginRsObj = $this->fetchNextObject($loginRs);
			/*if($loginRsObj->status == 0) {
				$this->commonObjContent->pushError('Account is not active.');
				$this->commonObjContent->wtRedirect("login.php");
			}else{
				$_SESSION["UNAME"] = $loginRsObj->username;
				$_SESSION["UID"] = $loginRsObj->uid;			
				$this->commonObjContent->wtRedirect("dashboard.php");
			}*/
				$_SESSION["UNAME"] = $loginRsObj->username;
				$_SESSION["UID"] = $loginRsObj->uid;			
				$this->commonObjContent->wtRedirect("dashboard.php");
		}
	}
	function logout(){
		$_SESSION["UNAME"] = null;
		$_SESSION["UID"] = null;		
		$this->commonObjContent->pushMessage("Logout successful");
		//session_destroy();
		$this->commonObjContent->wtRedirect("index.php");
	
	}
	
	function DeleteModel($ModelId){		
	$q = $this->query("SELECT tbl_model.*,tbl_model_pics.* FROM tbl_model LEFT JOIN tbl_model_pics ON tbl_model.id = tbl_model_pics.model_id where tbl_model.id = '$ModelId'");
		/*while($line = $this->fetchNextObject($q)){ 
		unlink("../uploaded_images/".stripslashes($line->model_image_name));
		unlink("../uploaded_images/".stripslashes($line->model_master_image));
		unlink("../uploaded_images/thumb/".stripslashes($line->model_master_image));
		}*/
		$this->query("DELETE FROM tbl_model WHERE id='$ModelId'");
		$this->query("DELETE FROM tbl_model_cover_photo WHERE model_id='$ModelId'");
		$this->query("DELETE FROM tbl_model_pics WHERE model_id='$ModelId'");
		
		$this->commonObjContent->pushMessage("Model has been removed successfully.");
		$this->commonObjContent->wtRedirect("models.php");
		}
			
}
?>