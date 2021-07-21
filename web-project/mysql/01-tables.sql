DROP TABLE IF EXISTS t_user;

CREATE TABLE t_user (
    id INT NOT NULL AUTO_INCREMENT,
    login VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
				active TINYINT(1) NOT NULL,
    created_at DATETIME NOT NULL,
    created_ip VARCHAR(15) NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS t_post;

CREATE TABLE t_post (
    id INT NOT NULL AUTO_INCREMENT,
    header VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    perex LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
				active TINYINT(1) NOT NULL,
    created_at DATETIME NOT NULL,
    private TINYINT(1) NOT NULL,
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE = utf8mb4_unicode_ci;

DROP TABLE IF EXISTS t_vote;

CREATE TABLE t_vote (
    id INT NOT NULL AUTO_INCREMENT,
    id_post INT(255) NOT NULL,
				id_user INT NOT NULL,
    up TINYINT(1) NOT NULL,
				active TINYINT(1) NOT NULL,
    created_at DATETIME NOT NULL,
    created_ip VARCHAR(15) NOT NULL,
    PRIMARY KEY (id),
				FOREIGN KEY (id_post) REFERENCES t_post(id),
				FOREIGN KEY (id_user) REFERENCES t_user(id)
);

