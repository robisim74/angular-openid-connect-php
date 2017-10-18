<h3>
    Welcome to the OAuth 2.0 Server!
</h3>
<p>
    You have been sent here by <strong>{{client_id}}</strong>. {{client_id}} would like to access the following data:
</p>


<p>
    Click the button below to complete the authorize request
</p>
<?php echo form_open('authorize/authorize_form_submit'); ?>

    <input type="submit" name="authorize" value="Yes, I authorize this request" />

    <input type="submit" name="cancel" value="Cancel" />

</form>