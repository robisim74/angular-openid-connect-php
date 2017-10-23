<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="<?= $this->meta_description ?>">
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

        <title><?= $this->title ?></title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/font-awesome/css/font-awesome.min.css">   
        <!-- DataTables -->
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">

        <!-- Custom styles -->
        <link href="<?= base_url(); ?>public/styles/app.css" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="<?= base_url(); ?>"><?= $this->title ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <?php if ($this->logged_in) : ?>
                        <li class="nav-item" id="menu-home">
                            <?= anchor('home', 'Home', array('class' => 'nav-link')) ?>                         
                        </li>
                    <?php endif ?>
                    <?php if ($this->is_admin) : ?>
                        <li class="nav-item" id="menu-admin">
                            <?= anchor('admin', 'Admin', array('class' => 'nav-link')) ?>
                        </li>
                    <?php endif ?>
                </ul>
                <!-- User Account -->
                <?php if ($this->logged_in) : ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-user"></i>
                            <span>Hi <?php echo $this->user->first_name; ?>!</span>
                        </button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <?= anchor('account/logout', 'Sign out', array('class' => 'dropdown-item')) ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </nav>

        <main role="main" class="container">

            <!-- Page content -->
            <?php echo $content; ?>

        </main>

        <!-- jQuery -->
        <script src="<?= base_url(); ?>public/assets/node_modules/jQuery/dist/jquery.slim.min.js"></script>
        <!-- Popper.js -->
        <script src="<?= base_url(); ?>public/assets/node_modules/popper.js/dist/umd/popper.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?= base_url(); ?>public/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="<?= base_url(); ?>public/assets/node_modules/datatables.net/js/jquery.dataTables.js"></script>
        <script src="<?= base_url(); ?>public/assets/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>    

        <?php foreach ($this->scripts as $script) : ?>
            <script src="<?= base_url() ?>public/scripts/<?= $script ?>.js"></script>
        <?php endforeach ?>
        
    </body>
</html>