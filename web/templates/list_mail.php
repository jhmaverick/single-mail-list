<?php if (!class_exists('Vesta')) exit; ?>
    <link rel="stylesheet" href="/plugin/single-mail-list/style.css"/>

    <div class="l-center">
      <div class="l-sort clearfix noselect">
          <a href="/edit/mail/" class="l-sort__create-btn edit" title="<?=__('Mail Manager')?>"></a>

        <div class="l-sort-toolbar clearfix">
          <table>
            <tr>
              <td class="step-right">
                <?
                  list($http_host, $port) = explode(':', $_SERVER["HTTP_HOST"].":");
                  $webmail = "http://".$http_host."/webmail/";
                  if (!empty($_SESSION['MAIL_URL'])) $webmail = $_SESSION['MAIL_URL'];
                ?>
                <a class="vst" href="<?=$webmail?>" target="_blank"><?=__('open webmail')?> <i></i></a>
              </td>
              <td class="l-sort-toolbar__search-box step-left">
                <form action="/search/" method="get">
                  <input type="hidden" name="token" value="<?=$_SESSION['token']?>" />
                  <input type="text" name="q" class="search-input" value="<? echo isset($_POST['q']) ? htmlspecialchars($_POST['q']) : '' ?>" />
                  <input type="submit" value="" class="l-sort-toolbar__search" onClick="return doSearch('/search/')" />
                </form>
              </td>
              <td class="toggle-all">
                <input id="toggle-all" type="checkbox" name="toggle-all" value="toggle-all" onChange="checkedAll('objects');">
                <label for="toggle-all" class="check-label toggle-all"><?=__('toggle all')?></label>
              </td>
              <td>
                <form action="/plugin/single-mail-list/bulk.php" method="post" id="objects">
                <input type="hidden" name="token" value="<?=$_SESSION['token']?>" />
                <div class="l-select">
                  <select name="action" id="">
                    <option value=""><?=__('apply to selected')?></option>
                    <option value="suspend"><?=__('suspend')?></option>
                    <option value="unsuspend"><?=__('unsuspend')?></option>
                    <option value="delete"><?=__('delete')?></option>
                  </select>
                </div>
                <input type="submit" value="" class="l-sort-toolbar__filter-apply" />
              </td>
            </tr>
          </table>
          <!--  -->
        </div>
      </div>
      <!-- /.l-sort -->
    </div>

    <div class="l-separator"></div>
    <!-- /.l-separator -->

      <?
        list($http_host, $port) = explode(':', $_SERVER["HTTP_HOST"].":");
        $webmail = "http://".$http_host."/webmail/";
        if (!empty($_SESSION['MAIL_URL'])) $webmail = $_SESSION['MAIL_URL'];

        foreach ($data as $key => $value) {
          ++$i;
          if ($data[$key]['SUSPENDED'] == 'yes') {
            $status = 'suspended';
            $spnd_action = 'unsuspend' ;
            $spnd_confirmation = 'UNSUSPEND_DOMAIN_CONFIRMATION' ;
          } else {
            $status = 'active';
            $spnd_action = 'suspend' ;
            $spnd_confirmation = 'SUSPEND_DOMAIN_CONFIRMATION' ;
          }
          if (empty($data[$key]['CATCHALL'])) {
            $data[$key]['CATCHALL'] = '/dev/null';
          }
      ?>

    <div class="l-center units single-mail-list <?= "units-block-$i" ?>">

      <div class="l-unit <? if($status == 'suspended') echo 'l-unit--suspended'; if($_SESSION['favourites']['MAIL'][$key] == 1) echo ' l-unit--starred'; ?>" v_unit_id="<?=$key?>" v_section="mail"
sort-date="<?=strtotime($data[$key]['DATE'].' '.$data[$key]['TIME'])?>" sort-name="<?=$key?>" sort-disk="<?=$data[$key]['U_DISK']?>"
sort-accounts="<?=$data[$key]['ACCOUNTS']?>" sort-star="<? if($_SESSION['favourites']['MAIL'][$key] == 1) echo "1"; else echo "0"; ?>">
        <div class="l-unit-toolbar clearfix">
          <!-- l-unit-toolbar__col -->
          <div class="l-unit-toolbar__col l-unit-toolbar__col--right noselect">
            <div class="actions-panel clearfix">
              <!--<div class="actions-panel__col actions-panel__logs shortcut-l" key-action="href"><a href="?domain=--><?//=$key?><!--">--><?//=__('list accounts',$data[$key]['ACCOUNTS'])?><!-- <i></i></a><span class="shortcut">&nbsp;L</span></div>-->
              <div class="actions-panel__col actions-panel__add shortcut-n" key-action="href"><a href="/add/mail/?domain=<?=$key?>"><?=__('add account')?> <i></i></a><span class="shortcut">&nbsp;N</span></div>
              <div class="actions-panel__col actions-panel__edit shortcut-enter" key-action="href"><a href="/edit/mail/?domain=<?=$key?>"><?=__('edit')?> <i></i></a><span class="shortcut enter">&nbsp;&#8629;</span></div>
              <div class="actions-panel__col actions-panel__suspend shortcut-s" key-action="js">
                <a id="<?=$spnd_action ?>_link_<?=$i?>" class="data-controls do_<?=$spnd_action?>">
                  <?=__($spnd_action)?> <i class="do_<?=$spnd_action?>"></i>
                  <input type="hidden" name="<?=$spnd_action?>_url" value="/<?=$spnd_action?>/mail/?domain=<?=$key?>&token=<?=$_SESSION['token']?>" />
                  <div id="<?=$spnd_action?>_dialog_<?=$i?>" class="confirmation-text-suspention hidden" title="<?=__('Confirmation')?>">
                    <p class="confirmation"><?=__($spnd_confirmation,$key)?></p>
                  </div>
                </a>
                <span class="shortcut">&nbsp;S</span>
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
          <div class="text-center favorite">
            <i class="l-icon-star" title="<?=__('save to favorites')?>"></i>
          </div>
        </div>
        <!-- /.l-unit__col -->
        <div class="l-unit__col l-unit__col--right">
          <div class="l-unit__name separate">
            <?=$key?> <? if($data[$key]['ACCOUNTS']) echo '<span>'.$data[$key]['ACCOUNTS'].' '.__('Accounts').'</span>';?>
            <span><?=__('Disk')?> <b><?=humanize_usage_size($data[$key]['U_DISK'])?></b> <?=humanize_usage_measure($data[$key]['U_DISK'])?></span>
            <span class="suspended"><?=__('suspended')?></span>
          </div>
          <!-- /.l-unit__name -->
        </div>
        <!-- /.l-unit__col -->


      </div>
      <!-- /.l-unit -->
      <!--div class="l-separator"></div-->
      <!-- /.l-separator -->

        <?php
        // Render mail accounts
        list_mail_acc($key);
        ?>
    </div>
    <?}?>


    <div id="vstobjects">
      <div class="l-separator"></div>
      <div class="l-center">
        <div class="l-unit-ft">
          <table class='data'></table>
          <div class="l-unit__col l-unit__col--left clearfix"></div>
          <div class="data-count l-unit__col l-unit__col--right clearfix">
            <?php
              if ( $i == 1) {
                echo __('1 domain');
              } else {
                echo __('%s domains',$i);
              }
            ?>
          </div>
        </div>
      </div>
    </div>
