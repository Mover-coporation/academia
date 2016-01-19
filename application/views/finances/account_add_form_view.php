
    <form role="form" id="add-school-account-form" method="post" action="<?php echo BASE_URL; ?>/finances/add_school_account" method="POST">
      <table class="table table-hover" width="100%">
        <tr>
          <td colspan="2">
            <div class="form-group">
              <h2>Add an account</h2>
            </div>
          </td>
        </tr>        
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><label for="account">Account Name</label></td>
          <td>
            <div class="form-group">
              <input type="text" class="textfield" id="account" name="account" placeholder="Enter a account name">
            </div>
          </td>
        </tr>
        
        <tr>
          <td  align="left">            
            <label for="purpose">Purpose</label>
          </td>
          <td  align="left">
            <div class="form-group">
              <textarea rows="4" class="textarea" id="purpose"  name="purpose" placeholder=""></textarea>
            </div>
          </td>
        </tr>
        <tfoot>
        <td colspan="2" align="right">
          <button type="button" class=" btn btn-default" onclick="submitme('add-school-account-form');" >Submit</button>
        </td>
        </tfoot>
      </table>
    </form>