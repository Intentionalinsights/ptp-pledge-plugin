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

.d-none {
    display: none;
}

.filters div {
    margin-top: 15px;
}

</style>

<script>

$(function() {
    var pledgeTakerContainers = $(".publicFigure");

    var containerGroups = {
        Official: $('.category-Official'),
        Group   : $('.category-Group'),
        Figure  : $('.category-Figure')
    };

    $('#nameFilter').keyup(function() {
        var query = $(this).val();
        if (!query) {
            pledgeTakerContainers.show();
            return;
        }
        var regex = new RegExp(query, 'i');
        pledgeTakerContainers.each(function() {
            var jContainer = $(this);
            var searchContent = jContainer.find('h3').html();
            if (!regex.test(searchContent)) {
                jContainer.hide();
                return;
            }
            jContainer.show();
        });
    });

    $('#categoryFilter').change(function() {

        var filter = $(this).val();

        if (!filter) {
            pledgeTakerContainers.removeClass('d-none');
            return;
        }

        pledgeTakerContainers.addClass('d-none');

        containerGroups[filter].removeClass('d-none');
    });
}
);
</script>

<div class="row filters">

    <div class="col-xs-12 col-sm-6">
        <label for='categoryFilter'>Show Pledge-Takers who are:</label>
        <select id='categoryFilter' class='form-control'>
            <option value=''>All Public Figures and Organizations</option>
            <option value='Official'>Elected/Appointed Officials and Candidates</option>
            <option value='Group'>Organizations</option>
            <option value='Figure'>Public Figures</option>
        </select>
    </div>

    <div class="col-xs-12 col-sm-6">
        <label for='nameFilter'>Search Public Figures/Organizations by Name:</label>
        <input type='text' id='nameFilter' class='form-control' placeholder='Search by Name'>
    </div>

</div>

<hr>

<?php foreach ($publicFigures as $figure): ?>

    <div class="publicFigure category-<?php echo $figure['category']; ?>" data-category="<?php echo $figure['category']; ?>">

        <h3><?php echo htmlentities($figure['name']); ?></h3>

        <?php foreach ($figure['links'] as $link): ?>
            <a class='figureLink' href='<?php echo htmlentities($link['url']); ?>'><?php echo $link['text']; ?></a>
        <?php endforeach; ?>

        <?php if ($figure['imageUrl']): ?>
            <br/>
            <img class='pFImage' src='<?php echo htmlentities($figure['imageUrl']); ?>' alt="<?php echo htmlentities($figure['name']); ?>">
        <?php endif; ?>

        <p class='figureDescription'><?php echo htmlentities($figure['description']); ?></p>
    </div>
    <div style='clear:both;'></div>

<?php endforeach; ?>
