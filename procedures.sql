DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_article_nav`(par_id INT)
BEGIN

	declare var_created datetime;
    declare var_archived bit;
    declare var_prev_id int;
    declare var_next_id int;

    select
		A.created,
        A.archived
	into
		var_created,
        var_archived
	from
		biden.editorial_article as A
	where
		A.id = par_id;

	SELECT
		A.id
	INTO
		var_prev_id
	FROM
		biden.editorial_article as A
	WHERE
		A.archived = var_archived
		and A.created < var_created
	ORDER BY
		A.created DESC
	LIMIT
		1;

    SELECT
		A.id
	INTO
		var_next_id
	FROM
		biden.editorial_article as A
	WHERE
		A.archived = var_archived
		and A.created > var_created
	ORDER BY
		A.created ASC
	LIMIT
		1;

	SELECT
		var_prev_id as prev_id,
		var_next_id as next_id,
		A.*
	FROM
		biden.editorial_article as A
	WHERE
		A.ID = par_id;

END$$
DELIMITER ;
