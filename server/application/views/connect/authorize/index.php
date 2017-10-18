<h3>
    OAuth 2.0 Server
</h3>
<p>
    <strong><?= $client_id ?></strong> would like to access the following data:
</p>

<?php foreach ($scopes as $scope) : ?>
    <p><?= $scope ?></p>
<?php endforeach ?>

<?php echo form_open('connect/authorize/authorize_form_submit'); ?>

    <input type="submit" name="cancel" value="Cancel" />

    <input type="submit" name="authorize" value="I authorize this request" />   

</form>