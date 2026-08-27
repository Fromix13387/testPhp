{extends file="layouts/main.tpl"}

{block name="content"}
    <div class="home">
        {foreach $categories as $category}
            <div class="category-section">
                <div class="category-section__header">
                    <h2 class="category-section__title">{$category.name|escape}</h2>
                    <a href="/category/{$category.id}" class="category-section__all">Все статьи</a>
                </div>
                <div class="article-grid">
                    {foreach $category.articles as $article}
                        <div class="article-card">
                            {if $article.image}
                                <img class="article-card__image" src="{$article.image|escape}" alt="{$article.name|escape}">
                            {/if}
                            <h3 class="article-card__title">{$article.name|escape}</h3>
                            {if isset($article.created_at)}
                                <div class="article-card__meta">
                                    <p>{$article.created_at|escape}</p>
                                </div>
                            {/if}
                            <p class="article-card__description">{$article.description|escape}</p>
                            <a href="/article/{$article.id}" class="article-card__read-more">Читать далее</a>
                        </div>
                    {/foreach}
                </div>
            </div>
        {/foreach}
    </div>
{/block}
