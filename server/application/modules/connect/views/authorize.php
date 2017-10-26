<?php echo form_open("connect/authorize/authorize_post", array('class' => 'form-authorize', 'novalidate' => '')) ?>
    <h2 class="form-authorize-heading"><?= $title ?></h2>
    <p>
        <strong><?= $client_id ?></strong> would like to access:
    </p>
    <ul class="list-group">
        <?php foreach ($scopes as $scope) : ?>
            <li class="list-group-item"><?= $scope ?></li>
        <?php endforeach ?>
    </ul>
    <button class="btn btn-lg btn-default btn-block" type="submit" name="cancel">Cancel</button>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="authorize">Authorize</button>
</form>