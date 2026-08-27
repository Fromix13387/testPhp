<?php


return new class {
    public function up(\app\core\Database $db): void {
        $db->execute('
            CREATE TABLE categories (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT NULL
            )
        ');

        $db->execute('
            CREATE TABLE articles (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                image VARCHAR(255) NULL,
                name VARCHAR(255) NOT NULL,
                description TEXT NULL,
                text LONGTEXT NOT NULL,
                views BIGINT UNSIGNED NOT NULL DEFAULT 0
            )
        ');

        $db->execute('
            CREATE TABLE article_category (
                article_id BIGINT UNSIGNED NOT NULL,
                category_id BIGINT UNSIGNED NOT NULL,
    
                PRIMARY KEY (article_id, category_id),
    
                FOREIGN KEY (article_id)
                    REFERENCES articles(id)
                    ON DELETE CASCADE,
    
                FOREIGN KEY (category_id)
                    REFERENCES categories(id)
                    ON DELETE CASCADE
            )
        ');
    }
};