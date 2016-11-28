<a href="#" class="toggle-link toggle-vendor-frames">toggle vendor stack frames</a>

<ul class="stack-trace">
<?php foreach ($error->getTrace() as $i => $stack): ?>
    <?php $class = (isset($stack['file']) && strpos(APP, $stack['file']) === false) ? 'vendor-frame' : 'app-frame'; ?>
    <li class="stack-frame <?php echo $class ?>">
    <?php if (isset($stack['function'])): ?>
        <a href="#" data-target="stack-frame-<?php echo $i ?>">
            <?php if (isset($stack['class'])): ?>
                <span class="stack-function">&rang; <?php echo h($stack['class'] . $stack['type'] . $stack['function']) ?></span>
            <?php else: ?>
                <span class="stack-function">&rang; <?php echo h($stack['function']) ?></span>
            <?php endif; ?>
            <span class="stack-file">
            <?php if (isset($stack['file'], $stack['line'])): ?>
                <?php echo h(Debugger::trimPath($stack['file'])) ?>, line <?php echo $stack['line'] ?>
            <?php else: ?>
                [internal function]
            <?php endif ?>
            </span>
        </a>
    <?php else: ?>
        <a href="#">&rang; [internal function]</a>
    <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
