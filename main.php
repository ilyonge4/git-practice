<?php
include_once('./_common.php');
define('_MAIN_', true);
include_once(G5_PATH.'/head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/main.css">', 0); 
?>

<div id="main_body">
 
<?
$main_content = get_site_content('site_main');
if($main_content) { 
	echo $main_content;
} else { 
?>

<?php } ?>
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
				<? include(G5_PATH."/template.bgm.php"); ?>
			</div>


<?
include_once(G5_PATH.'/tail.php');
?>