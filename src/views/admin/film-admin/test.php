<div id="actors-container">
    <?php foreach ($rolesList['acteurs'] as $index => $actor) { ?>
        <div class="actor-select">
            <label for="actor_<?= $index ?>">Acteur <?= $index + 1 ?> :</label>
            <select name="actors[]" id="actor_<?= $index ?>">
                <?php foreach ($allCastings as $option) { ?>
                    <option value="<?= $option['id'] ?>" 
                        <?= $option['id'] == $actor['id'] ? 'selected' : '' ?>>
                        <?= $option['firstName'] . ' ' . $option['lastName'] ?>
                    </option>
                <?php } ?>
            </select>
            <button type="button" class="remove-actor">Supprimer</button>
        </div>
    <?php } ?>
</div>
<button type="button" id="add-actor">Ajouter un acteur</button>
