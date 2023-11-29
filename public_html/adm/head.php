<header class="navbar navbar-expand-lg bd-navbar">
    <nav class="container-xxl bd-gutter flex-wrap flex-lg-nowrap">
        <div class="container-fluid">
            <a class="navbar-brand" href="/ad">관리자모드</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse m-t-md" id="navbarNavDropdown" style="">
                <ul class="nav justify-content-center">
                    <li class="nav-item m-r-sm">
                        <a class="nav-link" href="board/board_management.php">게시판관리</a>
                    </li>
                    <li class="nav-item m-r-sm">
                        <a class="nav-link" href="stat/statistics_list.php">사이트통계</a>
                    </li>
                    <li class="nav-item m-r-sm">
                        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> 로그아웃</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>


<script>
    $(document).ready(function() {
        var currentLocation = window.location.href;
        $("ul li a").each(function() {
            if (currentLocation.includes($(this).attr("href"))) {
                $(this).parent("li").addClass("active");
            }
        });
    });
</script>