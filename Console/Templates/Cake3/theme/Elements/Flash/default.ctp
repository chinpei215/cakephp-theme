<?php
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<div class="<?php echo h($class) ?>" onclick="this.classList.add('hidden');"><?php echo h($message) ?></div>
