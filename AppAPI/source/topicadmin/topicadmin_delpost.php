<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: topicadmin_delpost.php 30872 2012-06-27 10:11:44Z liulanbo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$_G['group']['allowdelpost']) {
	BfdApp::display_result('no_privilege_delpost');
	//showmessage('no_privilege_delpost');
}

$topiclist = $_GET['topiclist'];
$modpostsnum = count($topiclist);

$authorcount = $crimenum = 0;
$crimeauthor = '';
$pids = $posts = $authors = array();

if(!($deletepids = dimplode($topiclist))) {
//	showmessage('admin_delpost_invalid');
	BfdApp::display_result('admin_delpost_invalid');
} elseif(!$_G['group']['allowdelpost'] || !$_G['tid']) {
	//showmessage('admin_nopermission');
	BfdApp::display_result('admin_nopermission');
}  else {
	$posttable = getposttablebytid($_G['tid']);
	foreach(C::t('forum_post')->fetch_all('tid:'.$_G['tid'], $topiclist, false) as $post) {
		if($post['tid'] != $_G['tid']) {
			continue;
		}
		if($post['first'] == 1) {
			continue;
		} else {
			$authors[$post['authorid']] = 1;
			$pids[] = $post['pid'];
			$posts[] = $post;
		}
	}
}



	$reason = checkreasonpm();

	$uidarray = $puidarray = $auidarray = array();
	$losslessdel = $_G['setting']['losslessdel'] > 0 ? TIMESTAMP - $_G['setting']['losslessdel'] * 86400 : 0;

	if($pids) {
		require_once libfile('function/delete');
		if($_G['forum']['recyclebin']) {
			deletepost($pids, 'pid', true, false, true);
			manage_addnotify('verifyrecyclepost', $modpostsnum);
		} else {
			$logs = array();
			$ratelog = C::t('forum_ratelog')->fetch_all_by_pid($pids);
			$rposts = C::t('forum_post')->fetch_all('tid:'.$_G['tid'], $pids, false);
			foreach(C::t('forum_ratelog')->fetch_all_by_pid($pids) as $rpid => $author) {
				if($author['score'] > 0) {
					$rpost = $rposts[$rpid];
					updatemembercount($rpost['authorid'], array($author['extcredits'] => -$author['score']));
					$author['score'] = $_G['setting']['extcredits'][$id]['title'].' '.-$author['score'].' '.$_G['setting']['extcredits'][$id]['unit'];
					$logs[] = dhtmlspecialchars("$_G[timestamp]\t{$_G[member][username]}\t$_G[adminid]\t$rpost[author]\t$author[extcredits]\t$author[score]\t$thread[tid]\t$thread[subject]\t$delpostsubmit");
				}
			}
			if(!empty($logs)) {
				writelog('ratelog', $logs);
				unset($logs);
			}
			deletepost($pids, 'pid', true);
		}

		if($_GET['crimerecord']) {
			include_once libfile('function/member');

			foreach($posts as $post) {
				crime('recordaction', $post['authorid'], 'crime_delpost', lang('forum/misc', 'crime_postreason', array('reason' => $reason, 'tid' => $post['tid'], 'pid' => $post['pid'])));
			}
		}
	}

	updatethreadcount($_G['tid'], 1);
	updateforumcount($_G['fid']);

	$_G['forum']['threadcaches'] && deletethreadcaches($thread['tid']);

	$modaction = 'DLP';

	$resultarray = array(
	'redirect'	=> "forum.php?mod=viewthread&tid=$_G[tid]&page=$_GET[page]",
	'reasonpm'	=> ($sendreasonpm ? array('data' => $posts, 'var' => 'post', 'item' => 'reason_delete_post', 'notictype' => 'post') : array()),
	'reasonvar'	=> array('tid' => $thread['tid'], 'subject' => $thread['subject'], 'modaction' => $modaction, 'reason' => $reason),
	'modtids'	=> 0,
	'modlog'	=> $thread
	);


?>
