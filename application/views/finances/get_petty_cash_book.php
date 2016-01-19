<?php
$i = 0;
$style = array(0 => 'background-color: #FFFFFF;', 1 => 'background-color: #F0F0E1;');
?>
<tr class="listrow" style="<?php echo $style[$i % 2]; ?>">
  <td><?php echo date('d M, Y'); ?></td>
  <td><?php echo 'balance b/d'; ?></td>
  <td><?php echo 'balance brought down'; ?></td>
  <td align='right'><?php echo $opening['amount_dr']; ?></td>
  <td align='right'><?php echo $opening['amount_cr']; ?></td>
</tr>
<?php
$i=$i+1;
foreach ($data as $item) {
  ?>
  <tr class="listrow" style="<?php echo $style[$i % 2]; ?>">
    <td><?php echo date_format(new DateTime($item['date']), 'd M, Y'); ?></td>
    <td><?php echo $item['reference']; ?></td>
    <td><?php echo $item['particulars']; ?></td>
    <td align='right'><?php echo $item['cr_dr'] == '1' ? $item['amount'] : 0; ?></td>
    <td align='right'><?php echo $item['cr_dr'] == '0' ? $item['amount'] : 0; ?></td>
  </tr>
  <?php
  $i = $i + 1;
}
?>
<tr class="listrow" style="<?php echo $style[$i % 2]; ?>">
  <td><?php echo date('d M, Y'); ?></td>
  <td><?php echo 'balance c/f'; ?></td>
  <td><?php echo 'balance carried forward'; ?></td>
  <td align='right'><?php echo $closing['amount_cr']; ?></td>
  <td align='right'><?php echo $closing['amount_dr']; ?></td>
</tr>