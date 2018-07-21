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
.name-d-none {
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

        <h3><?php echo $figure['name']; ?></h3>

        <?php foreach ($figure['links'] as $link): ?>
            <a class='figureLink' href='<?php echo $link['url']; ?>'><?php echo $link['text']; ?></a>
        <?php endforeach; ?>

        <?php if ($figure['imageUrl']): ?>
            <br/>
            <img class='pFImage' src='<?php echo $figure['imageUrl']; ?>' alt="<?php echo $figure['name']; ?>">
        <?php endif; ?>

        <p class='figureDescription'><?php echo $figure['description']; ?></p>
    </div>
    <div style='clear:both;'></div>

<?php endforeach; ?>
