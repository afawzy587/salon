';
                                                             if(is_array($_order['item']))
                                                               {
                                                                   echo'<td id="item_'.$_order['item'][$k].'">
                                                                        <input type="text" name="item[]" value="'.$_order['item'][$k].'" hidden>
                                                                        <a  rel=\'tooltip\' title="'.$lang['delete'].'"class=\'btn btn-danger btn-link btn-sm delete_order_service\'>
                                                                            <i class=\'material-icons\'>close</i>
                                                                        </a>
                                                                     </td>
                                                                   ';
                                                               }else{
                                                                   echo'<td id="item_'.$k.'">
                                                                        <a  rel=\'tooltip\' title="'.$lang['delete'].'"class=\'btn btn-danger btn-link btn-sm delete_service\'>
                                                                            <i class=\'material-icons\'>close</i>
                                                                        </a>
                                                                     </td>
                                                                   ';
                                                               }

                                                             echo'


////////////////////////////////////////////order _edit///////////////////

                                                           if(is_array($_order['item']))
                                                           {
                                                               echo'<td id="item_'.$_order['item'][$k].'">
                                                                    <input type="text" name="item[]" value="'.$_order['item'][$k].'" hidden>
                                                                    <a  rel=\'tooltip\' title="'.$lang['delete'].'"class=\'btn btn-danger btn-link btn-sm delete_order_product\'>
                                                                        <i class=\'material-icons\'>close</i>
                                                                    </a>
                                                                 </td>
                                                               ';
                                                           }else{
                                                               echo'<td id="item_'.$k.'">
                                                                    <a  rel=\'tooltip\' title="'.$lang['delete'].'"class=\'btn btn-danger btn-link btn-sm delete_product\'>
                                                                        <i class=\'material-icons\'>close</i>
                                                                    </a>
                                                                 </td>
                                                               ';
                                                           }
                                                        echo'
