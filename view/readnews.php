<br>
<?php ViewNews::ReadNews($n, count($comments)); ?>
<br>
<?php ViewComments::CommentsByNews($comments); ?>
<br>
<?php ViewComments::CommentsForm((int)$n['id']); ?>
