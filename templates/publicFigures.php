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

.filters div {
    margin-top: 15px;
}

.prominent {
    /*background-color: #999;*/
}

.prominent h3 {
    color: goldenrod;
}

</style>

<script>

$(function() {
    var pledgeTakerContainers = $(".publicFigure");

    var containerGroups = {
        Official  : $('.category-Official'),
        Group     : $('.category-Group'),
        Figure    : $('.category-Figure'),
        Prominent : $('.prominent')
    };

    $('#nameFilter').keyup(function() {
        var query = $(this).val();
        if (!query) {
            pledgeTakerContainers.removeClass('name-d-none');
            return;
        }
        var regex = new RegExp(query, 'i');
        pledgeTakerContainers.each(function() {
            var jContainer = $(this);
            var searchContent = jContainer.find('h3').html();
            if (!regex.test(searchContent)) {
                jContainer.addClass('name-d-none');
                return;
            }
            jContainer.removeClass('name-d-none');
        });
    });

    $('#categoryFilter').change(function() {

        var filter = $(this).val();

        if (!filter) {
            pledgeTakerContainers.removeClass('category-d-none');
            return;
        }

        pledgeTakerContainers.addClass('category-d-none');

        containerGroups[filter].removeClass('category-d-none');
    });

    $("#prominentFilter").change(function() {
        if ($(this).is(':checked')) {
            pledgeTakerContainers.addClass('prominent-d-none');
            containerGroups.Prominent.removeClass('prominent-d-none');

            return;
        }

        pledgeTakerContainers.removeClass('prominent-d-none');
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

    <div class="col-xs-12">
        <label for="prominentFilter">
            <input type="checkbox" id="prominentFilter">
            Particularly Influential
        </label>
    </div>

</div>

<hr>

<?php foreach ($publicFigures as $figure): ?>

    <div class="publicFigure category-<?php echo $figure['category']; ?> <?php echo ($figure['prominent']) ? 'prominent' : ''; ?>" data-category="<?php echo $figure['category']; ?>">

        <h3><?php echo ($figure['prominent']) ? '<span class="glyphicon glyphicon-star"></span> ' : ''?><?php echo safe_html($figure['name']); ?></h3>

        <?php foreach ($figure['links'] as $link): ?>
            <a class='figureLink' href='<?php echo safe_html($link['url']); ?>'><?php echo safe_html($link['text']); ?></a>
        <?php endforeach; ?>

        <?php if ($figure['imageUrl']): ?>
            <br/>
            <img class='pFImage' src='<?php echo safe_html($figure['imageUrl']); ?>' alt="<?php echo safe_html($figure['name']); ?>">
        <?php endif; ?>

        <p class='figureDescription'><?php echo safe_html($figure['description']); ?></p>
    </div>
    <div style='clear:both;'></div>

<?php endforeach; ?>
