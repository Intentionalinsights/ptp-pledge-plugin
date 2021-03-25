<?php
/**
 * @author      Noah Heck (@noahheck)
 * @copyright   2018 Intentional Insights
 * @since 		2018-07-20
 */

?>

<style>

img.pFImage {
    max-width: 400px;
    width: auto;
    height: auto;
    max-height: 100px;
    float: left;
    padding-right: 5px;
}

.category-d-none,
.name-d-none,
.prominent-d-none {
    display: none;
}

.prominent h1 {
    color: goldenrod;
}

</style>

<?php foreach ($publicFigures as $figure): ?>

    <div class="publicFigure category-<?php echo $figure['category']; ?> <?php echo ($figure['prominent']) ? 'prominent' : ''; ?>" data-category="<?php echo $figure['category']; ?>">

        <h1><?php echo ($figure['prominent']) ? '<span class="glyphicon glyphicon-star"></span> ' : ''?><?php echo safe_html($figure['name']); ?></h1>

        <?php foreach ($figure['links'] as $link): ?>
            <a class='figureLink' href='<?php echo safe_html($link['url']); ?>'><?php echo safe_html($link['text']); ?></a>
        <?php endforeach; ?>

        <?php if ($figure['imageUrl']): ?>
            <br/>
            <img class='pFImage' src='<?php echo safe_html($figure['imageUrl']); ?>' alt="<?php echo safe_html($figure['name']); ?>"  onError="this.style.display='none'"/>
        <?php endif; ?>

        <p class='figureDescription'><?php echo safe_html($figure['description']); ?></p>
    </div>
    <div style='clear:both;'></div>
    <br><br><br>

<?php endforeach; ?>
