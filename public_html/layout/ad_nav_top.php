<style>
    .horizontal-list {
        list-style: none;
        padding: 0;
        display: flex; /* flexbox를 사용하여 가로 정렬 */
    }

    .horizontal-list li {
        margin-right: 20px; /* 각 항목 간 간격 설정 */
    }

    .horizontal-list a {
        text-decoration: none;
        color: #333;
    }
</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">관리자모드</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/ad">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ad/board/board_management.php">게시판관리</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ad/statistics/statistics_list.php">사이트통계</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ad/logout.php"><i class="fa fa-sign-out"></i> 로그아웃</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>