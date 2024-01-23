<?= $this->extend('backend/layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Tabs</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Settings
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-4">
    <h5 class="h4 text-blue mb-20">Customtab Tab</h5>
    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#general_settings" role="tab" aria-selected="true">General Settings</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="false">Logo & Favicon</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#social_media" role="tab" aria-selected="false">Social Media</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="general_settings" role="tabpanel">
                <div class="pd-20">
                    <form action="<?= route_to('update-general-settings') ?>" method="POST" id="general_settings_form">
                        <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" class="ci_csrf_data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog Title</label>
                                    <input type="text" name="blog_title" class="form-control" placeholder="Enter Blog Title" value="<?= get_settings()->blog_title ?>">
                                    <span class="text-danger error-text blog_title_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog Email</label>
                                    <input type="text" name="blog_email" class="form-control" placeholder="Enter Blog Email" value="<?= get_settings()->blog_email ?>">
                                    <span class=" text-danger error-text blog_email_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog Phone No.</label>
                                    <input type="text" name="blog_phone" class="form-control" placeholder="Enter Blog Phone" value="<?= get_settings()->blog_phone ?>">
                                    <span class=" text-danger error-text blog_phone_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog Meta Keywords</label>
                                    <input type="text" name="blog_meta_keywords" class="form-control" placeholder="Enter Blog Meta Keywords" value="<?= get_settings()->blog_meta_keywords ?>">
                                    <span class="text-danger error-text blog_meta_keywords_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Blog Meta Description</label>
                            <textarea name="blog_meta_description" id="" cols="4" rows="3" class="form-control" placeholder="Write blog meta description"><?= get_settings()->blog_meta_description ?></textarea>
                            <span class="text-danger error-text blog_meta_description_error"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- <div class="tab-pane fade" id="logo_favicon" role="tabpanel">
                <div class="pd-20">
                    --- Logo & Favicon ---
                </div>
            </div> -->
            <div class="tab-pane fade" id="social_media" role="tabpanel">
                <div class="pd-20">
                    <form action="<?= route_to('update-social-media'); ?>" method="post" id="social_media_form">
                        <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" class="ci_csrf_data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Twitter URL</label>
                                    <input type="text" name="twitter_url" class="form-control" placeholder="Enter twitter page URL" value="<?= get_social_media()->twitter_url; ?>">
                                    <span class="text-danger error-text twitter_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Instagram URL</label>
                                    <input type="text" name="instagram_url" class="form-control" placeholder="Enter instagram page URL" value="<?= get_social_media()->instagram_url; ?>">
                                    <span class="text-danger error-text instagram_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Youtube URL</label>
                                    <input type="text" name="youtube_url" class="form-control" placeholder="Enter youtube page URL" value="<?= get_social_media()->youtube_url; ?>">
                                    <span class="text-danger error-text youtube_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Github URL</label>
                                    <input type="text" name="github_url" class="form-control" placeholder="Enter github page URL" value="<?= get_social_media()->github_url; ?>">
                                    <span class="text-danger error-text github_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tiktok URL</label>
                                    <input type="text" name="tiktok_url" class="form-control" placeholder="Enter tiktok page URL" value="<?= get_social_media()->tiktok_url; ?>">
                                    <span class="text-danger error-text tiktok_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Whatsapp URL</label>
                                    <input type="text" name="whatsapp_url" class="form-control" placeholder="Enter whatsapp page URL" value="<?= get_social_media()->whatsapp_url; ?>">
                                    <span class="text-danger error-text whatsapp_url_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>
<script>
    $('#general_settings_form').on('submit', function(e) {
        e.preventDefault();
        //! CSRF Hash
        var csrfName = $('.ci_csrf_data').attr('name'); //! CSRF Token Name
        var csrfHash = $('.ci_csrf_data').val(); //! CSRF HASH
        var form = this;
        var formdata = new FormData(form);
        formdata.append(csrfName, csrfHash);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            cache: false,
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                // console.log(response);
                //! Update CSRF Hash
                $('.ci_csrf_data').val(response.token);

                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        $('.blog-title-footer').each(function() {
                            $(this).html("\u00A9 2024 " + response.setting_info.blog_title + ". All rights reserved.");
                        });
                        $('.blog-title').each(function() {
                            $(this).html(response.setting_info.blog_title + " - " + "<?= isset($tabTitle) ? $tabTitle : 'New Page Title'; ?>");
                        });
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                } else {
                    $.each(response.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });

    $('#social_media_form').on('submit', function(e) {
        e.preventDefault();
        //! CSRF Hash
        var csrfName = $('.ci_csrf_data').attr('name'); //! CSRF Token Name
        var csrfHash = $('.ci_csrf_data').val(); //! CSRF HASH
        var form = this;
        var formdata = new FormData(form);
        formdata.append(csrfName, csrfHash);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            cache: false,
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                // console.log(response);
                //! Update CSRF Hash
                $('.ci_csrf_data').val(response.token);

                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                } else {
                    $.each(response.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });
</script>
<?= $this->endSection(); ?>