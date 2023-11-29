<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/include/auth.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/nav_top.php"; ?>

<div class="wrapper wrapper-content">
    <div class="container">

        <div class="row mb-3">
            <span class="font-bold" style="font-size: 20px;" id="page_title"></span>
        </div>
        
        <div class="row mb-3" id="login_check_div">
            <div class="col-sm-6">
                <!--<label class="col-sm-2 form-label"><span class="text-danger">*</span> 이름</label>-->
                <input form="form" type="text" id="user_name" name="user_name" class="form-control form-control-sm required" autocomplete="off" placeholder="이름">
            </div>
            <div class="col-sm-6">
                <!--<label class="col-sm-2 form-label"><span class="text-danger">*</span> 비밀번호</label>-->
                <input form="form" type="password" id="write_password" name="write_password" class="form-control form-control-sm required" autocomplete="off" placeholder="비밀번호">
            </div>
        </div>

        <div class="row mb-3" id="secret_div">
            <div class="col-sm-12">
                <div class="custom-control custom-checkbox">
                    <input form="form" type="checkbox" class="custom-control-input" id="is_secret" name="is_secret" style="width: 20px; height: 20px;vertical-align: middle;  position: relative;  bottom: 3px;">
                    <label class="custom-control-label" for="is_secret" data-toggle="popover" data-trigger="hover" data-placement="top" title="비밀글일 경우 체크해주세요."  data-original-title="">&nbsp비밀글여부</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12">
                <!--<label class="col-sm-2 form-label"><span class="text-danger">*</span> 제목</label>-->
                <input form="form" type="text" id="title" name="title" class="form-control form-control-sm required" autocomplete="off" placeholder="제목을 입력해주세요." required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12">
                <!--<label class="col-sm-2 form-label"><span class="text-danger"></span> 내용</label>-->
                <textarea form="form" id="content" name="content" class=""></textarea>
            </div>
        </div>

        <div class="row mb-3">
                <div class="form-group">
                    <!--<label class="col-xs-2 control-label">첨부파일</label>-->
                    <div class="col-xs-10">

                        <div class="file_list">

                        </div>

                    </div>
                </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <button form="form" type="button" class="btn btn-default btn-sm" id="return_list">취소</button>
                <button form="form" type="submit" class="btn btn-primary btn-sm">등록</button>
            </div>
        </div>

    </div>

    <form id="form" name="form">
        <input type="hidden" id="idx" name="idx">
        <input type="hidden" id="form_table_name" name="form_table_name">
    </form>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/page/board/board_write_js.php"; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/layout/footer.php"; ?>