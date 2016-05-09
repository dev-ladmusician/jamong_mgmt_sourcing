<div ng-controller="CreateCtrl">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                STEP 3. 영상 정보 XML 입력
            </h1>
        </section>

        <section class="content" >
            <div class="row">
                <div class="col-md-12 jamong-pannel">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">영상 정보</h3>
                        </div>
                        <form class="box-body" method="post"
                              action="<?= site_url('/api/content/create_xml?contentId='.$content->inum)?>"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label>영상 경로:</label>
                                <div>https://s3-ap-northeast-1.amazonaws.com/dongshin.movie/original/<?php echo $content->filename.'.'.$content->format; ?></div>
                            </div>
                            <div class="form-group">
                                <label>xml:</label>
                                <input id="jamong-content-xml"
                                       name="jamong-content-xml"
                                       type="file"
                                       class="form-control" />
                            </div>
                            <div class="form-group pull-right">
                                <input class="btn btn-default" type="submit" style="margin-left: 3px; margin-bottom: 3px;" value="업로드">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
