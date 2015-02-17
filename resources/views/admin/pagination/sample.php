<?php
    $presenter = new Sharenjoy\Cmsharenjoy\Service\Pagination\SamplePresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
    <ul class="pagination">
            <?php echo $presenter->render(); ?>
    </ul>
<?php endif; ?>
