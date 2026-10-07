<?php
use App\Core\Auth;
require __DIR__ . '/../partials/header.php';
?>
<div class="page-heading reveal">
    <div><span class="eyebrow"><?= $mode === 'edit' ? 'Update record' : 'Create record' ?></span><h1><?= e($title) ?></h1><p>Complete the details below. Required fields are marked with an asterisk.</p></div>
    <a class="btn btn-ghost" href="<?= e(url('module', ['module' => $moduleKey])) ?>"><i class="bi bi-arrow-left"></i> Back to <?= e($module['title']) ?></a>
</div>

<section class="form-panel panel reveal delay-1">
    <div class="form-panel-side"><span class="big-module-icon"><i class="bi <?= e($module['icon']) ?>"></i></span><span class="eyebrow"><?= e($module['singular']) ?></span><h2><?= $mode === 'edit' ? 'Keep the record accurate.' : 'Add something new.' ?></h2><p><?= e($module['description']) ?></p><div class="form-tip"><i class="bi bi-shield-check"></i><div><strong>Validated & protected</strong><small>Forms use server-side validation, prepared queries and CSRF protection.</small></div></div></div>
    <form method="post" action="<?= e(url('module_save', ['module' => $moduleKey] + ($record ? ['id' => $record['id']] : []))) ?>" class="form-grid form-panel-main" novalidate>
        <?= csrf_field() ?>
        <?php foreach ($module['fields'] as $name => $field): ?>
            <?php
                $type = $field['type'];
                if ($type === 'owner_relation' && !Auth::isAdmin()) continue;
                if (str_starts_with($type, 'admin_') && !Auth::isAdmin()) continue;
                $value = $record[$name] ?? ($field['default'] ?? '');
                $required = !empty($field['required']);
                $wide = in_array($type, ['textarea','admin_textarea'], true);
            ?>
            <label class="field <?= $wide ? 'field-span-2' : '' ?>">
                <span><?= e($field['label']) ?><?= $required ? ' *' : '' ?></span>
                <?php if ($type === 'textarea' || $type === 'admin_textarea'): ?>
                    <textarea name="<?= e($name) ?>" rows="4" placeholder="<?= e($field['placeholder'] ?? '') ?>" <?= $required ? 'required' : '' ?>><?= e($value) ?></textarea>
                <?php elseif ($type === 'select' || $type === 'admin_select'): ?>
                    <div class="select-shell"><select name="<?= e($name) ?>" <?= $required ? 'required' : '' ?>><?php foreach ($field['options'] as $optionValue => $optionLabel): ?><option value="<?= e($optionValue) ?>" <?= (string) $value === (string) $optionValue ? 'selected' : '' ?>><?= e($optionLabel) ?></option><?php endforeach; ?></select><i class="bi bi-chevron-down"></i></div>
                <?php elseif ($type === 'relation' || $type === 'owner_relation'): ?>
                    <div class="select-shell"><select name="<?= e($name) ?>" <?= $required ? 'required' : '' ?>><option value="">Select <?= e(strtolower($field['label'])) ?></option><?php foreach ($relationOptions[$name] ?? [] as $option): ?><option value="<?= (int) $option['id'] ?>" <?= (string) $value === (string) $option['id'] ? 'selected' : '' ?>><?= e($option['label']) ?></option><?php endforeach; ?></select><i class="bi bi-chevron-down"></i></div>
                <?php else: ?>
                    <input type="<?= e($type) ?>" name="<?= e($name) ?>" value="<?= e($value) ?>" placeholder="<?= e($field['placeholder'] ?? '') ?>" <?= isset($field['min']) ? 'min="'.e($field['min']).'"' : '' ?> <?= $required ? 'required' : '' ?>>
                <?php endif; ?>
            </label>
        <?php endforeach; ?>
        <div class="field-span-2 form-actions"><a class="btn btn-ghost" href="<?= e(url('module', ['module' => $moduleKey])) ?>">Cancel</a><button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle"></i> <?= $mode === 'edit' ? 'Save changes' : 'Create ' . e($module['singular']) ?></button></div>
    </form>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
