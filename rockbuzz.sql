CREATE TABLE `authors` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `authors` (`id`, `name`) VALUES
(1, 'Autor Teste');


CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `slug` varchar(100) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `post_tag` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tags` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Teste', 'teste@teste.com.br', '202cb962ac59075b964b07152d234b70');


ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_postsAuthors` (`author_id`);


ALTER TABLE `post_tag`
  ADD KEY `FK_postsTagsPost` (`post_id`),
  ADD KEY `FK_postsTagsTag` (`tag_id`);


ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `authors`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `tags`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
