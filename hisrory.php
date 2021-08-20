if(!empty($arrHistory)){
            if(!empty($arrUser)){
                $resUser = \Bitrix\Main\UserTable::getList(array(
                    'select' => array('ID','LOGIN'),
                    'filter' => ['ID'=> $arrUser]
                ));
                while ($arUser = $resUser->fetch()) {
                    $arUsers[$arUser['ID']] = $arUser;
                }
            }
            if(!empty($arrProviderSadovodId)){
                $providerSadovod =  \Sadovod\Local\Hlblock\Provider::getList('UF_ID_SADOVOD', ['select' => ['UF_XML_ID', 'ID', 'UF_NAME', 'UF_ID_SADOVOD'], 'filter' => ['UF_ID_SADOVOD' => $arrProviderSadovodId]]);
            }

			foreach ($arrHistory as $idZak => $vid) {
                
				$class = '';
				getClass(1);
				
				foreach ($vid as $CODE => $vVal1) {
					if($CODE == 'COUNT_SOBR' || $CODE == 'COUNT_TRANSFER') continue;
												
						$class = '';

						getClass(1);
                        
                        $l_sob = 5; $min_str = false;
						if ($_POST['info_view'] == 'min') {
							$l_sob = 3; $min_str = true;
						}
                        
                        $lastDate = ''; $i = 0;
                        $vVal1 = array_reverse($vVal1);
						foreach ($vVal1 as $idVal => $vVal) {
                            // if($arrUserCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_AFTER'] > 1){
                                // if($arrUserCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_AFTER'] > $vVal['UF_VALUE_AFTER']){
                                //     continue;
                                // }
                                
                            // }elseif($arrUserCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_AFTER'] <= 1 && strtotime($vVal['UF_DATE']->format('d.m.Y')) == strtotime(date('d.m.Y')) && $arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_USER_ID'] == $vVal['UF_USER_ID']){
                            //     if($arrUserCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_AFTER'] > $vVal['UF_VALUE_AFTER']){
                            //         continue;
                            //     }
                            // }
                           
					        $user = (!empty($arUsers[$vVal['UF_USER_ID']]['LOGIN']))?$arUsers[$vVal['UF_USER_ID']]['LOGIN']:$vVal['UF_USER_ID'];
					        if(!$Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']]) $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] = '';
					        
                            
                            //Разделяем полосой если разные даты рядом 
                            $curDate = $vVal['UF_DATE']->format('d.m.Y');
                            if (empty($lastDate)) $lastDate = $vVal['UF_DATE']->format('d.m.Y');
                            if ($lastDate != $curDate) {
                            	//$Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="line_history"></div>';
                            	$lastDate = $curDate;
                            }
                            
                            //Показываем сразу только последние 4 действия
                            $i++;
                            /*if (count($vVal1) == 4) {
                            	if ((count($vVal1)-3) == $i) $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="hide_history">';
                      
                            }*/
                            
                           
                           
                            // if(strtotime($vVal['UF_DATE']->format('d.m.Y')) == strtotime(date('d.m.Y')) && $arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_USER_ID'] == $vVal['UF_USER_ID']){
                            //     if ($i == 1) {
                            //         $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="block_history">';
                            //     }
                            //     if ($i == 2) {
                            //         $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="hide_history">';
                            //     }
                            //     if(count($vVal1) > 1 && $i == count($vVal1)){
                            //         $colorClass = 'oneUser red_bg white';
                            //     }
                                
                            // }else{
                                if ($i == 1) {
                                    $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="block_history">';
                                }
                                if ($i == 5) {
                                    $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="hide_history">';
                                }
                            // }
                            
                            
                           
						    $color = getDiffColor(strtotime($vVal['UF_DATE']));
                            
                            $date_t_h = '<span class="bl_hover">'.((!$min_str)?mb_substr($vVal['UF_SOURCE'],0,3).'&nbsp;&nbsp;':'').' '.$vVal['UF_DATE']->format('H:i:s').'&nbsp;&nbsp;'.$vVal['UF_DATE']->format('d.m').'</span>';
                            if (date('d.m.Y') != $vVal['UF_DATE']->format('d.m.Y')) {
				        	    $date_t_h = '('.( dateDiff(strtotime($vVal['UF_DATE'])) ).')'.$date_t_h;
                            }

                            $l_sob_2 = $l_sob;
							if (in_array($user, ['Dil','saodat','Nar'])) {
								$l_sob_2 = 1;
								$user['0'] = strtoupper($user['0']);
							}
                            $login_str = '<span class="login_'/*.$user*/.'">'.mb_substr($user, 0, $l_sob_2).'</span>';

					        if($vVal['UF_PROPERTY_CODE'] == 'UF_QUANTITY_FACT'){
                                // if(strtotime($vVal['UF_DATE']->format('d.m.Y')) == strtotime(date('d.m.Y')) && $arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_USER_ID'] == $vVal['UF_USER_ID']){
                                //     if(!$y[$idZak][$vVal['UF_DATE']->format('d.m.Y')]) $y[$idZak][$vVal['UF_DATE']->format('d.m.Y')] = 1;
                                
                                //     //показываем в формате 1д,2д,3д с наведением и если сегодня, вообще не выводим 
                                    
                                //     if($vVal['UF_VALUE_AFTER']>=$vVal['UF_VALUE_BEFORE']){
                                //         if(empty($class)){
                                //             $x = true;
                                //         }
                                //         //((!$min_str)?'('.$arrDateCheck[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']][$vVal['ID']].') ':'') .
                                //         if($x && !empty($vid['COUNT_SOBR'][$vVal['UF_DATE']->format('d.m.Y')]['COUNT'][$y[$idZak][$vVal['UF_DATE']->format('d.m.Y')]])){
                                //             $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 1 '.$colorClass.'" style="background:'.$color.'">'.'<span class="'.$vid['COUNT_SOBR'][$vVal['UF_DATE']->format('d.m.Y')]['CLASS'].'">'.$login_str.' '.$arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
                                //             $x = false;
                                //             $y[$idZak][$vVal['UF_DATE']->format('d.m.Y')] ++;
                                //         }
                                //         // else{
                                //         //     $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 2 '.$colorClass.'" style="background:'.$color.'">'.'<span class="">'.$login_str.' '.$arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
                                //         // }
                                //     }elseif($vVal['UF_VALUE_AFTER']<$vVal['UF_VALUE_BEFORE']){
                                //         $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 3 '.$colorClass.'"  style="background:'.$color.'">'.'<span class="">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
                                //         if($vVal['UF_SOURCE'] == 'sklad')$class = '';	
                                            
                                //     }
                                // }elseif(strtotime($vVal['UF_DATE']->format('d.m.Y')) == strtotime(date('d.m.Y')) && $arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_USER_ID'] != $vVal['UF_USER_ID']){
                                //     if(!$y[$idZak][$vVal['UF_DATE']->format('d.m.Y')]) $y[$idZak][$vVal['UF_DATE']->format('d.m.Y')] = 1;
                                
                                //     //показываем в формате 1д,2д,3д с наведением и если сегодня, вообще не выводим 
                                    
                                //     if($vVal['UF_VALUE_AFTER']>=$vVal['UF_VALUE_BEFORE']){
                                //         if(empty($class)){
                                //             $x = true;
                                //         }
                                //         //((!$min_str)?'('.$arrDateCheck[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']][$vVal['ID']].') ':'') .
                                //         if($x && !empty($vid['COUNT_SOBR'][$vVal['UF_DATE']->format('d.m.Y')]['COUNT'][$y[$idZak][$vVal['UF_DATE']->format('d.m.Y')]])){
                                //             $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 1" style="background:'.$color.'">'.'<span class="'.$vid['COUNT_SOBR'][$vVal['UF_DATE']->format('d.m.Y')]['CLASS'].'">'.$login_str.' '.$arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_AFTER'].'->'.$arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
                                //             $x = false;
                                //             $y[$idZak][$vVal['UF_DATE']->format('d.m.Y')] ++;
                                //         }
                                //         else{
                                //             $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 2" style="background:'.$color.'">'.'<span class="">'.$login_str.' '.$arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_AFTER'].'->'.$arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
                                //         }
                                //     }elseif($vVal['UF_VALUE_AFTER']<$vVal['UF_VALUE_BEFORE']){
                                //         // $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 3 '.$colorClass.'"  style="background:'.$color.'">'.'<span class="">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
                                //         // if($vVal['UF_SOURCE'] == 'sklad')$class = '';	
                                            
                                //     }
                                // }else{
                                    if(!$y[$idZak][$vVal['UF_DATE']->format('d.m.Y')]) $y[$idZak][$vVal['UF_DATE']->format('d.m.Y')] = 1;
                            
                                    //показываем в формате 1д,2д,3д с наведением и если сегодня, вообще не выводим 
                                    
                                    if($vVal['UF_VALUE_AFTER']>=$vVal['UF_VALUE_BEFORE']){
                                        if(empty($class)){
                                            $x = true;
                                        }
                                        //((!$min_str)?'('.$arrDateCheck[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']][$vVal['ID']].') ':'') .
                                        if($x && !empty($vid['COUNT_SOBR'][$vVal['UF_DATE']->format('d.m.Y')]['COUNT'][$y[$idZak][$vVal['UF_DATE']->format('d.m.Y')]])){
                                            $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 1" style="background:'.$color.'">'.'<span class="'.$vid['COUNT_SOBR'][$vVal['UF_DATE']->format('d.m.Y')]['CLASS'].'">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
                                            $x = false;
                                            $y[$idZak][$vVal['UF_DATE']->format('d.m.Y')] ++;
                                        }else{
                                            $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 2" style="background:'.$color.'">'.'<span class="">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
                                        }
                                    }elseif($vVal['UF_VALUE_AFTER']<$vVal['UF_VALUE_BEFORE']){
                                        $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 3"  style="background:'.$color.'">'.'<span class="">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
                                        if($vVal['UF_SOURCE'] == 'sklad')$class = '';	
                                             
                                    }
                                // }
                                
                                
						    }elseif($vVal['UF_PROPERTY_CODE'] == 'UF_BRAK_MODEL' || $vVal['UF_PROPERTY_CODE'] == 'UF_BRAK_SIZE' || $vVal['UF_PROPERTY_CODE'] == 'UF_BRAK' || $vVal['UF_PROPERTY_CODE'] == 'UF_BRAK_REJECT' || $vVal['UF_PROPERTY_CODE'] == 'UF_BRAK_NOFOUND'){

						    	
						        if($vVal['UF_VALUE_AFTER']>=$vVal['UF_VALUE_BEFORE']){
						        	$x = true;
						        	
						        	if($x && !empty($vid['COUNT_TRANSFER'][$vVal['UF_PROPERTY_CODE']]['COUNT'])){
						        		$Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 5 '.$colorClass.'" style="background:'.$color.'">'.'<span class="'.$vid['COUNT_SOBR'][$vVal['UF_DATE']->format('d.m.Y')]['CLASS2'].'">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
						        		$x = false;
						        	}else{
						        		$Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 6 '.$colorClass.'" style="background:'.$color.'">'.'<span class="">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
						        	}
						        }elseif($vVal['UF_VALUE_AFTER']<$vVal['UF_VALUE_BEFORE']){
						        	$Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 7 '.$colorClass.'" style="background:'.$color.'">' .'<span class="">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';		        	
						        }
						    }elseif($vVal['UF_PROPERTY_CODE'] == 'UF_CHECK' || $vVal['UF_PROPERTY_CODE'] == 'UF_BRAK_SORT' || $vVal['UF_PROPERTY_CODE'] == 'UF_RECHECK' || $vVal['UF_PROPERTY_CODE'] == 'UF_SORT_FAKT' || $vVal['UF_PROPERTY_CODE'] == 'UF_UPAK_FAKT'){
						    	
						        if($vVal['UF_VALUE_AFTER']>=$vVal['UF_VALUE_BEFORE']){
						        	$x = true;
						        	
						        	if($x){
						        		$Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 8 '.$colorClass.'" style="background:'.$color.'">'.'<span class="'.$vid['COUNT_SOBR'][$vVal['UF_DATE']->format('d.m.Y')]['CLASS2'].'">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
						        		$x = false;
						        	}else{
						        		$Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 9 '.$colorClass.'" style="background:'.$color.'">'.'<span class="">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';
						        	}
						        }elseif($vVal['UF_VALUE_AFTER']<$vVal['UF_VALUE_BEFORE']){
                                    $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<div class="l_hist date_time_hover 10 '.$colorClass.'" style="background:'.$color.'">'.'<span class="">'.$login_str.' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].' '.$date_t_h.'</span></div>';		        
                                    	
                                }

                            }elseif($vVal['UF_PROPERTY_CODE'] == 'UF_PROVIDER_ID' ){
                                
                                $sign = (empty($vVal['UF_VALUE_BEFORE']))?'->':'=';
                                $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<span class="1 '.$colorClass.'">'.$providerSadovod[$vVal['UF_VALUE_BEFORE']]['UF_NAME'].' '.$sign.' '.$providerSadovod[$vVal['UF_VALUE_AFTER']]['UF_NAME'].' ('.$vVal['UF_DATE']->format('d.m').' '.mb_substr($user, 0, $l_sob).' '.')</span><br>';
                     
						    }elseif($vVal['UF_PROPERTY_CODE'] == 'UF_RETURN_COL' ){
                                
                                $sign = (empty($vVal['UF_VALUE_BEFORE']))?'->':'=';
                                $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<span class="2 '.$colorClass.'"> ('.$vVal['UF_DATE']->format('d.m H:i').' '.mb_substr($user, 0, $l_sob).' '.')</span><br>';
                     
						    }else{
						    	//((!$min_str)?'('.$arrDateCheck[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']][$vVal['ID']].') ':'')
						    	//((!$min_str)?mb_substr($vVal['UF_SOURCE'],0,3).' ':'')
					    		$Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '<span class="date_time_hover"><span class="3 '.$colorClass.'">'.$vVal['UF_DATE']->format('d.m').' '.mb_substr($user, 0, $l_sob).' '.$vVal['UF_VALUE_BEFORE'].'->'.$vVal['UF_VALUE_AFTER'].'</span><span class="bl_hover">'.$vVal['UF_DATE']->format('H:i').'</span></span><br>';
						    }

                            //Кнопка для показа остальных действий (сразу только последние 4 действия)
                            /*if (count($vVal1) > 4 && $i == count($vVal1)) {
                            	$Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '</div><div class="show_all_history">...</div>';
                            }*/
                            // if(strtotime($vVal['UF_DATE']->format('d.m.Y')) == strtotime(date('d.m.Y')) && $arrCollector[$vVal['UF_ZAKAZY_ID']]['UF_USER_ID'] == $vVal['UF_USER_ID']){
                            //     if (count($vVal1) > 1 && $i == count($vVal1)) {
                            //         $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '</div><div class="show_all_history">...</div>';
                            //     }
                            // }else{
                                if (count($vVal1) > 4 && $i == count($vVal1)) {
                                    $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '</div><div class="show_all_history">...</div>';
                                }
                            // }
                           
                            if ($i == count($vVal1)) {
						        $Result[$vVal['UF_ZAKAZY_ID']][$vVal['UF_PROPERTY_CODE']] .= '</div>';
                            }
                           
                           
				    	}
				    // 
			    }
		    }
           

		    if(!empty($Result)) echo \Bitrix\Main\Web\Json::encode($Result); 

		   
        }
