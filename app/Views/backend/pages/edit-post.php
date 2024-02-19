<?= $this->extend('backend/layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Edit Post</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Post
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="<?= route_to('all-posts') ?>" class="btn btn-primary">View All Post</a>
        </div>
    </div>
</div>

<form action="<?= route_to('update-post'); ?>" method="post" autocomplete="off" enctype="multipart/form-data" id="updatePostForm">
    <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" class="ci_csrf_data">
    <input type="hidden" name="post_id" value="<?= $post->id; ?>">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Post Title</b></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter post title" value="<?= $post->title; ?>">
                        <span class="text-danger error-text title_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Content</b></label>
                        <textarea name="content" cols="30" rows="10" class="form-control" placeholder="Type...."><?= $post->content; ?></textarea>
                        <span class="text-danger error-text content_error"></span>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-2">
                <h5 class="card-header weight-500">SEO</h5>
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Post Meta Keywords</b><small> (Separated by comma)</small></label>
                        <input type="text" name="meta_keywords" class="form-control" placeholder="Enter post meta keywords" value="<?= $post->meta_keywords; ?>">
                    </div>
                    <div class="form-group">
                        <label for=""><b>Post Meta Description</b></label>
                        <textarea name="meta_description" cols="30" rows="10" class="form-control" placeholder="Type meta description"><?= $post->meta_description; ?></textarea>
                        <span class="text-danger error-text meta_description_error"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Post Category</b></label>
                        <select name="category" class="custom-select form-control">
                            <?php

                            use App\Libraries\CIAuth;

                            foreach ($categories as $category) : ?>
                                <option value="<?= $category->id ?>" <?= $category->id == $post->category_id ? 'selected' : '' ?>><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text-danger error-text category_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Post Featured Image</b></label>
                        <input type="file" name="featured_image" class="form-control-file form-control" height="auto" value="<?= $post->featured_image; ?>">
                        <span class="text-danger error-text featured_image_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Tags</b></label>
                        <input type="text" name="tags" class="form-control" placeholder="Enter tags" data-role="tagsinput" value="<?= $post->tags; ?>">
                        <span class="text-danger error-text tags_error"></span>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for=""><b>Visibility</b></label>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" name="visibility" id="customRadio1" class="custom-control-input" value="1" <?= $post->visibility == 1 ? 'checked' : '' ?>>
                            <label for="customRadio1" class="custom-control-label">Public</label>
                        </div>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" name="visibility" id="customRadio2" class="custom-control-input" value="0" <?= $post->visibility == 0 ? 'checked' : '' ?>>
                            <label for="customRadio2" class="custom-control-label">Private</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Update Post</button>
    </div>
</form>

<?= $this->endSection(); ?>
<?= $this->section('stylesheets'); ?>

<link rel="stylesheet" href="/backend/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>

<script src="/backend/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="/extra-assets/ckeditor/ckeditor.js"></script>

<script>
    $(function() {
        var elfinderPath = '/extra-assets/elFinder/elfinder.src.php?integration=ckeditor&uid=<?= CIAuth::id() ?>';
        // alert(elfinderPath);
        CKEDITOR.replace('content', {
            filebrowserBrowseUrl: elfinderPath,
            filebrowserImageBrowseUrl: elfinderPath + '&type=image',
            removeDialogTabs: 'link:upload;image:upload'
        });
    });
    //! Form Add Post
    $('#updatePostForm').on('submit', function(e) {
        e.preventDefault();
        //! CSRF Hash
        var csrfName = $('.ci_csrf_data').attr('name'); //! CSRF Token Name
        var csrfHash = $('.ci_csrf_data').val(); //! CSRF HASH
        var form = this;
        var content = CKEDITOR.instances.content.getData();
        var formdata = new FormData(form);
        formdata.append(csrfName, csrfHash);
        formdata.append('content', content);

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
                //! Update CSRF Hash
                $('.ci_csrf_data').val(response.token);

                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        // $(form)[0].reset();
                        // $('input[name="tags"]').tagsinput('removeall');
                        // CKEDITOR.instances.content.setData('');
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