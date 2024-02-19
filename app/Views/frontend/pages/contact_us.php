<?= $this->extend('frontend/layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-12">
        <div class="breadcrumbs mb-4"> <a href="<?= route_to('/') ?>">Home</a>
            <span class="mx-1">/</span> <a href="#!">Contact</a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="pr-0 pr-lg-4">
            <div class="content">Contact us if there is something wrong with our website or if you want to join our team.
                <div class="mt-5">
                    <p class="h3 mb-3 font-weight-normal">
                        <a class="text-dark" href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= get_settings()->blog_email ?>" target="_blank"><?= get_settings()->blog_email ?></a>
                    </p>
                    </p>
                    <p class="mb-3">
                        <a class="text-dark" href="https://wa.me/<?= get_settings()->blog_phone ?>" target="_blank"><?= get_settings()->blog_phone ?></a>
                    </p>
                    <p class="mb-2">42 Kimeli Street, Tengah Subdistrict, Kramat Jati District, East Jakarta, Indonesia</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mt-4 mt-lg-0">
        <?php $validation = \Config\Services::validation(); ?>
        <form method="POST" action="<?= route_to('contact-us-send') ?>" class="row">
            <?= csrf_field(); ?>
            <div>
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('fail'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control mb-4" placeholder="Name" name="name" id="name" value="<?= set_value('name') ?>">
            </div>
            <?php if ($validation->getError('name')) : ?>
                <div class="d-block text-danger" style="margin-top: -25px; margin-bottom: 15px;">
                    <?= $validation->getError('name'); ?>
                </div>
            <?php endif; ?>
            <div class="col-md-6">
                <input type="text" class="form-control mb-4" placeholder="Email" name="email" id="email" value="<?= set_value('email') ?>">
            </div>
            <?php if ($validation->getError('email')) : ?>
                <div class="d-block text-danger" style="margin-top: -25px; margin-bottom: 15px;">
                    <?= $validation->getError('email'); ?>
                </div>
            <?php endif; ?>
            <div class="col-12">
                <input type="text" class="form-control mb-4" placeholder="Subject" name="subject" id="subject" value="<?= set_value('subject') ?>">
            </div>
            <?php if ($validation->getError('subject')) : ?>
                <div class="d-block text-danger" style="margin-top: -25px; margin-bottom: 15px;">
                    <?= $validation->getError('subject'); ?>
                </div>
            <?php endif; ?>
            <div class="col-12">
                <textarea name="message" id="message" class="form-control mb-4" placeholder="Type You Message Here" rows="5"><?= route_to('message') ?></textarea>
            </div>
            <?php if ($validation->getError('message')) : ?>
                <div class="d-block text-danger" style="margin-top: -25px; margin-bottom: 15px;">
                    <?= $validation->getError('message'); ?>
                </div>
            <?php endif; ?>
            <div class="col-12">
                <button class="btn btn-outline-primary" type="submit">Send Message</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>