<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php'); 

/*********** Logo Data ************/
$logo = get_logo('pc');
$m_logo = get_logo('mo');

$logo_data = "";
if(!$logo && !$m_logo)$logo_data=$config['cf_title'];
else{
if($logo)		$logo_data .= "<img src='".$logo."' ";
if($m_logo)		$logo_data .= "class='only-pc' /><img src='".$m_logo."' class='not-pc'";
if($logo_data)	$logo_data.= " />";
}
/*********************************/

$main_link=get_main_link();
?>

<!-- 헤더 영역 -->
<header id="header" style="display:none;">
	<div class="fix-layout">
		<!-- 로고 영역 : PC 로고 / 모바일 로고 동시 출력 - 디자인 사용을 체크하지 않을 시, 제대로 출력되지 않을 수 있습니다. -->
		<!-- 관리자 기능을 사용하지 않고 로고를 넣고 싶을 시, < ? = $ log_data ? > 항목을 제거 하고 <img> 태그를 넣으세요. -->
		<?if($config['cf_logo_use']!='N'){?>
		<h1 id="logo">
			<a href="<?=$main_link?>">
				<?=$logo_data?>
			</a>
		</h1>
		<?}?>
		<!-- 로고를 삭제하고 싶을 경우 위의 <h1 ... </h1> 부분을 삭제하시면 됩니다 -->

		<!-- 모바일 모드에서 메뉴를 열고 닫기 할 수 있는 버튼 -->
		<a href="#gnb_wrapper" id="gnb_control_box">
			<img src="<?=G5_IMG_URL?>/ico_menu_control_pannel.png" alt="메뉴열고닫기" />
		</a>
		<script>
		$('#gnb_control_box').on('click', function() {
			$('body').toggleClass('open-gnb');
			return false;
		});
		</script>
		<!-- 모바일 메뉴 열고 닫기 버튼 종료 -->

		<div id="gnb_wrapper">
			<?
			if($config['cf_menu_content']){
			$menu_co=explode(",",$config['cf_menu_content']);
			$menu_content = get_site_content($menu_co[1]);
			echo '<div id="gnb">'.$menu_content.'</div>';
			}else{
		/**************************************************************
		----------------------------메뉴 영역 시작----------------------------
		* 원하실 경우 하단의 <div id="gnb"> ....  </div> 부분을 수정/삭제 해주세요.
		**************************************************************/?> 
			
			<div id="gnb">
				<ul id="no_design_gnb">
				<?
				
			 $sql = " select *
                            from {$g5['menu_table']}
                            where me_use = '1'
                              and length(me_code) = '2'
                            order by me_order*1, me_id ";
                $result = sql_query($sql, false); 
				$count=sql_fetch($sql);
                $menu_datas = array();
			if($count['me_id']){ $sql = " select *
                            from {$g5['menu_table']}
                            where me_use = '1'
                              and length(me_code) = '2'
                            order by me_order*1, me_id ";
                $result = sql_query($sql, false); 
                $menu_datas = array();

                for ($i=0; $row=sql_fetch_array($result); $i++) {
                    $menu_datas[$i] = $row;

                    $sql2 = " select *
                                from {$g5['menu_table']}
                                where me_use = '1'
                                  and length(me_code) = '4'
                                  and substring(me_code, 1, 2) = '{$row['me_code']}'
                                order by me_order*1, me_id ";
                    $result2 = sql_query($sql2);
                    for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                        $menu_datas[$i]['sub'][$k] = $row2;
                    }

                }

                $i = 0;
                foreach( $menu_datas as $row ){
                    if( empty($row) ) continue; 
					$color=$de['menu_text']['cs_value'];
					$over=$de['menu_text']['cs_etc_2'];
					if($row['me_color']) $color=$row['me_color'];
					if($row['me_over']) $over=$row['me_over'];
					$img_link='';
					if($row['me_img']){
						if($row['me_img2']){
						$img_link="<img src=\"{$row['me_img']}\" onmouseenter=\"this.src='{$row['me_img2']}'\" onmouseleave=\"this.src='{$row['me_img']}'\" alt=\"{$row['me_name']}\">";
						}
						else{
						$img_link='<img src="'.$row['me_img'].'" alt="'.$row['me_name'].'">';
						}
					}
                ?>
				<?if($member['mb_level']>=$row['me_level']){?>
                <li class="gnb_1dli <?if($i==0) echo " main";?>" >
                    <a href="<?php echo $row['me_link']?>"  target="_<?=$row['me_target']?>" class="gnb_1da" onMouseOver="this.style.color='<?=$over?>'" onMouseOut="this.style.color='<?=$color?>'" style="color:<?=$color?>;"><?php if($row['me_img']) echo $img_link; else echo $row['me_name']; ?></a>
                    
                </li>
				<?}?>
                <?php
                $i++;
                }   //end foreach $row
			}else{
			
			
			
				$bbs_list=sql_query("select bo_table,bo_subject from {$g5['board_table']} where bo_use_search='1'"); 
					$bbs_admin=sql_query("select bo_table,bo_subject from {$g5['board_table']} where bo_use_search='0'");
					for ($i=0;$bbs=sql_fetch_array($bbs_list);$i++){ 
					?>
					<li>
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>"><?=$bbs['bo_subject']?></a>
					</li>
				<?}unset($bbs);
					if($is_admin){
					for ($i=0;$bbs=sql_fetch_array($bbs_admin);$i++){ 
					?>
					<li>
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bbs['bo_table']?>"><?=$bbs['bo_subject']?></a>
					</li>
				<?}unset($bbs);}
			}?> 
				</ul>
			</div>
			<div id="login_box" class="txt-center"><?if ($is_member){?>
				<p class="name"><?=$member['mb_nick']?></p>
				<?if($is_admin){?><a href="<?=G5_ADMIN_URL?>" class="ui-btn admin small" target="_blank">관리자</a>
				<a href="<?php echo G5_ADMIN_URL ?>/board_form.php" class="ui-btn small">게시판생성</a><?}?>
				<?if($is_member && !$is_admin){?><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="ol_after_info" class="ui-btn small">정보수정</a><?}?>
				<a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout" class="ui-btn small etc">로그아웃</a> 
				<?}else{?>
				<a href="<?=G5_BBS_URL?>/login.php" class="ui-btn point small">로그인</a>
				<?if($config['cf_1']){?> <a href="<?php echo G5_BBS_URL ?>/register.php" class="ui-btn small etc"><b>회원가입</b></a><?}?>
				<?}?>
			</div>
			<div id="bgm_box">
				<? 
				/*
				include(G5_PATH."/template.bgm.php"); 
				*/
				?>
			</div>
			
			<? /**************************************************************
			----------------------------메뉴 영역 끝----------------------------
			**************************************************************/ }?> 
		</div>
	</div>
</header>
<!-- // 헤더 영역 -->
<script src="../js/mouse.js"></script>
<div class="background">
    <div class="outerbox">
        <div class="wrapper">
            <div class="wrapper__left">
                <div class="wrapper__left__header">
                    <div class="today">
                        TODAY <span class="zero">0</span> | TOTAL <span class="count">12345</span> 
                    </div>
                </div>
                <div class="wrapper__left__body">
                    <div class="header">
                        <div class=headerGrey>
                        </div>
                        <div class="line"></div>
                        <div class="profileWrapper">
												<div class="main_txt">
												<div class="profileWrapper">
                                <div class="profile">
                                    <i class="fas fa-user"></i> 이름
                                </div>
                                <div class="profile">
                                    <i class="fas fa-phone-alt"></i> Phone
                                </div>
                                <div class="profile">
                                    <i class="fas fa-envelope"></i> E-mail
                                </div>
                                <div class="profile">
                                    <i class="fas fa-star"></i> Instagram
                                </div>
                            </div>
                            <!--<a href="http://babbietien.dothome.co.kr/" style="display:block; margin:20px 0 20px;">
                                <img src="./img/banner.png" alt="" />
                            </a>
                            <p style="font-size:9px">http://babbietien.dothome.co.kr/img/banner.png</p>
                            <br>
                            <span class="blackbox">取扱注意</span><span class="pinktxt">Warning!!</span>
                            <br>
                            <span class="whitetxt">Horror | Petit Gore | Grotesque | 19禁 </span>
                            <br>
																--->
                            <p class="border_txt">
                                1차위주 그림 계정 <a href="https://twitter.com/babie_draw"
                                    style="color:#cca2ff;">@babie_draw</a>
                            </p>
                            <p>배너 교환 자유 | 가입, 댓글 자유 (사랑합니다)</p>
                        </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="feelWrapper">
                            <div class="feel">일촌 파도타기</div>
                            <select class="feelSelect">
                                <option>MYMYMYMY</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper__right">
						<ul class="menu_wrap">
                        <li onClick="location.href='<?=G5_URL?>'">
                            <a class="menu_img">
                                <span>Main</span>
                            </a>
                        </li>
                        <li onClick="location.href='<?=G5_URL?>'">
                            <a class="menu_img">
                                <span>PROFILE</span>
                            </a>
                        </li>
                        <li onClick="location.href='<?=G5_URL?>/bbs/board.php?bo_table=lover'">
                            <a class="menu_img">
                                <span>Lover</span>
                            </a>
                        </li>
                        <li onClick="location.href='<?=G5_URL?>/bbs/board.php?bo_table=mmb'">
                            <a class="menu_img">
                                <span>MMB</span>
                            </a>
                        </li>
                        <li onClick="location.href='<?=G5_URL?>/bbs/board.php?bo_table=commu'">
                            <a class="menu_img">
                                <span>LOAD</span>
                            </a>
                        </li>
                        <li onClick="location.href='<?=G5_URL?>/bbs/board.php?bo_table=memo'">
                            <a class="menu_img">
                                <span>MEMO</span>
                            </a>
                        </li>
                        <li onClick="location.href='<?=G5_URL?>/bbs/board.php?bo_table=CMMS'">
                            <a class="menu_img">
                                <span>Commission</span>
                            </a>
                        </li>
                        <li onClick="location.href='<?=G5_URL?>/bbs/board.php?bo_table=trpg'">
                            <a class="menu_img">
                                <span>TRPG</span>
                            </a>
                        </li>
                    </ul>
                <div class="wrapper__right__header">
                    <div class="wrapper__right__title">表示プロパティ</div>
                    <div class="wrapper__right__setting">사생활보호설정<i class="fas fa-caret-right bbbb"></i></div>
                </div>
                <div class="wrapper__right__body">
								<section id="body">
					<div class="fix-layout"> 
			<hr class="padding" />
