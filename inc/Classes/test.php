<tr>
                                        <td>
                                            <h4><?php echo $lang['orders'];?></h4>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="checkhour custom-control-input" name="orders_view" value="1" id="<?php echo $lang['orders_view'];?>"
                                                       <?php if($_group){if($_group['orders_view'] == 1){echo 'checked';}}else{if($u['orders_view'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['orders_view'];?>"><b><?php echo $lang['active'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="checkhour custom-control-input" name="orders_add" value="1" id="<?php echo $lang['orders_add'];?>"
                                                       <?php if($_group){if($_group['orders_add'] == 1){echo 'checked';}}else{if($u['orders_edit'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['orders_add'];?>"><b><?php echo $lang['active'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="checkhour custom-control-input" name="orders_delete" value="1" id="<?php echo $lang['orders_delete'];?>"
                                                       <?php if($_group){if($_group['orders_delete'] == 1){echo 'checked';}}else{if($u['orders_delete'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['orders_delete'];?>"><b><?php echo $lang['active'];?></b></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox col-md-3">
                                                <input type="checkbox" class="checkhour custom-control-input" name="orders_edit" value="1" id="<?php echo $lang['orders_edit'];?>"
                                                       <?php if($_group){if($_group['orders_edit'] == 1){echo 'checked';}}else{if($u['orders_edit'] == 1){echo 'checked';}}?>/>
                                                 <label class="custom-control-label" for="<?php echo $lang['orders_edit'];?>"><b><?php echo $lang['active'];?></b></label>
                                            </div>
                                        </td>
                                      </tr>
