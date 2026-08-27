{extends file="layouts/main.tpl"}

{block name="content"}
    <div class="category-page">
        <div class="category-page__info">
            <h1 class="category-page__title">{$category.name|escape}</h1>
            <p class="category-page__description">{$category.description|escape}</p>
        </div>
        <div class="category-page__controls">
            <span>Сортировка:</span>
            <a href="?sort=date&order=asc" class="category-page__sort">По дате asc </a>
            <a href="?sort=date&order=desc" class="category-page__sort">По дате desc </a>
            <a href="?sort=views&order=asc" class="category-page__sort">По просмотрам asc</a>
            <a href="?sort=views&order=desc" class="category-page__sort">По просмотрам desc</a>
        </div>
        <div class="category-page__articles">
            {foreach $articles as $article}
                <div class="article-card">
                    {if $article.image}
                        <img class="article-card__image" src="{$article.image|escape}" alt="{$article.name|escape}">
                    {/if}

                    <div class="article-card__content">
                        <h2 class="article-card__title">{$article.name|escape}</h2>
                        <div class="article-card__meta">
                            <p>{$article.created_at|escape}</p>
                            <p>{$article.views|escape} просмотров</p>
                        </div>
                        <p class="article-card__description">{$article.description|escape}</p>
                        <a class="article-card__read-more" href="/article/{$article.id}">Читать далее</a>
                    </div>
                </div>
            {/foreach}
        </div>

        <div class="pagination">
            {foreach $pagination.pages as $page}
                <a href="?page={$page}&sort={$sort}&order={$order}" class="{if $page == $pagination.page}pagination__active{/if}">{$page}</a>
            {/foreach}
        </div>
    </div>
{/block}
