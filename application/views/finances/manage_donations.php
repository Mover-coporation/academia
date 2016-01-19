

<div class="content">
  <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable' onmouseover="$('#testing').datepicker()">            
    <?php
    if (isset($msg)) {
      echo "<tr><td colspan='4'>" . format_notice($msg) . "</td></tr>";
    }
    ?>          
    <tr>
      <td valign="top">
        <?php
        $page_list = array(1);
        if (!empty($page_list)) {
          ?>
        <?php }
        else {
          ?>
          <div>No classes have been added.</div>
        <?php }
        ?>
      </td>
    </tr>
  </table>
</div>
