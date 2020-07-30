DECLARE
	@ID INT,
	@PrevID INT,
	@NextID INT,
	@Created DATE,
	@Modified DATE,
	@Featured BIT,
	@Archived BIT;

/* GetPrevNextCurr */

select
	@Created := A.created
from
	biden.editorial_article as A
where
	A.archived = @Archived
	and A.id = @ID;

SELECT
	@PrevID := A.ID
FROM
	biden.editorial_article as A
WHERE
	A.archived = @Archived
	and A.created < @Created
ORDER BY
	A.created DESC
LIMIT
	1;

SELECT
	@NextID := A.ID
FROM
	biden.editorial_article as A
WHERE
	A.archived = @Archived
	and A.created > @Created
ORDER BY
	A.created ASC
LIMIT
	1;

SELECT
	@PrevID as PrevID,
	@NextID as NextID,
	A.*
FROM
	biden.editorial_article as A
WHERE
	A.ID = @ID;