<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/auth.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/nav_top.php"; ?>

<script src="https://unpkg.com/konva@9.2.3/konva.min.js"></script>

<style>
    input::-webkit-input-placeholder {
        font-size: 15px;
    }
</style>

<div class="wrapper wrapper-content">

    <div class="container">

        <button form="form_main" type="button" id="btn_create" class="btn btn-success btn-lg block m-b font-bold">서명하기</button>


    </div>
</div>

<div class="modal fade show" id="modal_sign" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document" style="max-width:1080px;">
        <div class="modal-content" style="width: 1150px;">


            <div class="modal-body">
                <div class="" id="container" style="background-color: #f0f0f0;width: 1080px; height: 1920px;"></div>

                <div id="sign_view" class="text-center mb-1" style="display: none;">
                    <span style=" position: relative; top: 70px;"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button form="form_main" type="button" id="btn_save" class="btn btn-success">저장</button>
                <div id="sign_download_div" class="text-center mb-1" style="display: none;">
                    <a type="button" id="btn_download" class="btn btn-warning">다운로드</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/page/sign/sign_js.php"; ?>
<?php //include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/footer.php"; ?>
