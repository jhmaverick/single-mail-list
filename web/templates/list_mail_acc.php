<?php if (!class_exists('Vesta')) exit; ?>
      <?
        foreach ($data as $key => $value) {
          ++$i;
          if ($data[$key]['SUSPENDED'] == 'yes') {
            $status = 'suspended';
            $spnd_action = 'unsuspend' ;
            $spnd_confirmation = 'UNSUSPEND_MAIL_ACCOUNT_CONFIRMATION' ;
          } else {
            $status = 'active';
            $spnd_action = 'suspend';
            $spnd_confirmation = 'SUSPEND_MAIL_ACCOUNT_CONFIRMATION' ;
          }
      ?>


      <div class="l-unit <? if($status == 'suspended') echo 'l-unit--suspended'; if($_SESSION['favourites']['MAIL_ACC'][$key."@".$_GET['domain']] == 1) echo ' l-unit--starred'; ?>"
 v_unit_id="<?=$key."@".$_GET['domain']?>" v_section="mail_acc" sort-date="<?=strtotime($data[$key]['DATE'].' '.$data[$key]['TIME'])?>" sort-name="<?=$key?>" sort-disk="<?$data[$key]['U_DISK']?>"
sort-star="<? if($_SESSION['favourites']['MAIL_ACC'][$key."@".$_GET['domain']] == 1) echo '1'; else echo '0'; ?>">
        <div class="l-unit-toolbar clearfix">
          <div class="l-unit-toolbar__col l-unit-toolbar__col--left">
            <input id="check<?php echo $i ?>" class="ch-toggle" type="checkbox" name="account[<?= $_GET['domain'] ?>][]" value="<?php echo $key ?>">
            <label for="check<?php echo $i ?>" class="check-label"></label>
          </div>
          <!-- l-unit-toolbar__col -->
          <div class="l-unit-toolbar__col l-unit-toolbar__col--right noselect">
            <div class="actions-panel clearfix">
              <div class="actions-panel__col actions-panel__edit shortcut-enter" key-action="href"><a href="/edit/mail/?domain=<?=htmlspecialchars($_GET['domain'])?>&account=<?=$key?>"><?=__('edit')?> <i></i></a><span class="shortcut enter">&nbsp;&#8629;</span></div>
              <div class="actions-panel__col actions-panel__suspend shortcut-s" key-action="js">
                <a id="<?=$spnd_action ?>_link_<?=$i?>" class="data-controls do_<?=$spnd_action?>">
                  <?=__($spnd_action)?> <i class="do_<?=$spnd_action?>"></i>
                  <input type="hidden" name="<?=$spnd_action?>_url" value="/<?=$spnd_action?>/mail/?domain=<?=htmlspecialchars($_GET['domain'])?>&account=<?php echo $key ?>&token=<?=$_SESSION['token']?>" />
                  <div id="<?=$spnd_action?>_dialog_<?=$i?>" class="confirmation-text-suspention hidden" title="<?=__('Confirmation')?>">
                    <p class="confirmation"><?=__($spnd_confirmation,$key)?></p>
                  </div>
                </a>
                <span class="shortcut">&nbsp;S</span>
              </div>
              <div class="actions-panel__col actions-panel__delete shortcut-delete" key-action="js">
                <a id="delete_link_<?=$i?>" class="data-controls do_delete">
                  <?=__('delete')?> <i class="do_delete"></i>
                  <input type="hidden" name="delete_url" value="/delete/mail/?domain=<?=htmlspecialchars($_GET['domain'])?>&account=<?=$key?>&token=<?=$_SESSION['token']?>" />
                  <div id="delete_dialog_<?=$i?>" class="confirmation-text-delete hidden" title="<?=__('Confirmation')?>">
                    <p class="confirmation"><?=__('DELETE_MAIL_ACCOUNT_CONFIRMATION',$key)?></p>
                  </div>
                </a>
                <span class="shortcut delete">&nbsp;Del</span>
              </div>
            </div>
            <!-- /.actiona-panel -->
          </div>
          <!-- l-unit-toolbar__col -->
        </div>
        <!-- /.l-unit-toolbar -->

        <div class="l-unit__col l-unit__col--left clearfix">
          <div class="l-unit__date">
            <?=translate_date($data[$key]['DATE'])?>
          </div>
          <div class="l-unit__suspended"><?=__('suspended')?></div>
          <div class="text-center">
            <i class="l-icon-star" title="<?=__('save to favorites')?>"></i>
          </div>
        </div>
        <!-- /.l-unit__col -->
        <div class="l-unit__col l-unit__col--right">
          <div class="l-unit__name separate">
            <?=$key."@".$_GET['domain']?> <span><?=str_replace(',', ', ', $data[$key]['ALIAS'])?></span>
          </div>
          <!-- /.l-unit__name -->
          <div class="l-unit__stats">
            <table>
              <tr>
                <td>
                  <div class="l-unit__stat-cols clearfix graph">
                    <div class="l-unit__stat-col l-unit__stat-col--left">
                      <?=__('Disk')?>
                    </div>
                    <div class="l-unit__stat-col l-unit__stat-col--right text-right volume">
                      <b><?=humanize_usage_size($data[$key]['U_DISK'])?></b> <?=humanize_usage_measure($data[$key]['U_DISK'])?>
                    </div>
                  </div>
                  <div class="l-percent">
                    <div class="l-percent__fill" style="width: <?=get_percentage($data[$key]['U_DISK'],$data[$key]['QUOTA'])?>%"></div>
                  </div>
                  <!-- /.percent -->
                </td>
                <td>
                  <div class="l-unit__stat-cols clearfix">
                    <div class="l-unit__stat-col l-unit__stat-col--left"><?=__('Quota')?>:</div>
                    <div class="l-unit__stat-col l-unit__stat-col--right">
                      <b><?=__(humanize_usage_size($data[$key]['QUOTA'])) ?></b> <?=__(humanize_usage_measure($data[$key]['QUOTA'])) ?>
                    </div>
                  </div>
                </td>
                <td>
                  <? if($data[$key]['AUTOREPLY'] == 'no'){ ?>
                    <div class="l-unit__stat-cols clearfix disabled"><?=__('Autoreply')?></div>
                  <? } else {?>
                    <div class="l-unit__stat-cols clearfix">
                      <div class="l-unit__stat-col l-unit__stat-col--left"><?=__('Autoreply')?>:</div>
                      <div class="l-unit__stat-col l-unit__stat-col--right">
                        <b><?=__($data[$key]['AUTOREPLY'])?></b>
                      </div>
                    </div>
                  <? } ?>
                </td>
              </tr>
              <tr>
                <td></td>
                <td colspan="2">
                  <div class="l-unit__stat-cols clearfix">
                    <div class="l-unit__stat-col l-unit__stat-col--left"><?=__('Forward to')?>:</div>
                    <div class="l-unit__stat-col l-unit__stat-col--right wide">
                      <b><?=str_replace(',', ', ', $data[$key]['FWD'])?></b>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
          <!-- /.l-unit__stats -->
        </div>
        <!-- /.l-unit__col -->
      </div>
      <!-- /.l-unit -->
      <!--div class="l-separator"></div-->
      <!-- /.l-separator -->
      <?}?>
