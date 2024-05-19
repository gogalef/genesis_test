CREATE SCHEMA usd AUTHORIZATION dbuser;
CREATE TABLE usd.usd_value (
	"date" date NOT NULL,
	value float4 NOT NULL,
	CONSTRAINT usd_value_pk PRIMARY KEY (date)
);
CREATE TABLE usd.user_emails (
	id int4 GENERATED ALWAYS AS IDENTITY( INCREMENT BY 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1 NO CYCLE) NOT NULL,
	email varchar NOT NULL,
	subscribe bool DEFAULT false NOT NULL,
	CONSTRAINT user_emails_id PRIMARY KEY (id)
);
CREATE INDEX user_emails_email_idx ON usd.user_emails USING btree (email);

CREATE OR REPLACE FUNCTION usd.sp_select_current_value(date_ date)
 RETURNS jsonb
 LANGUAGE plpgsql
 COST 1
AS $function$
/**
 * Функція для вибору всієї інформації про одне налаштування системи
 */
BEGIN
    PERFORM
        1
    FROM
        usd.usd_value
    WHERE
        date = date_
    LIMIT
        1;

    IF FOUND
    THEN
        -- SELECT DATA --------------------------------------------------------
        RETURN
        (
            SELECT
                row_to_json(z)::jsonb
            FROM
                (
                    SELECT
                        jsonb_agg(z1)                        as "data"
                    FROM
                        (
                            SELECT
                                *
                            FROM
                                usd.usd_value
                            WHERE
                                date = date_
                            LIMIT
                                1
                        ) z1
                ) z
        );
    ELSE
        RETURN jsonb_build_object( 'error', 1002 );
    END IF;
END;
$function$
;

CREATE OR REPLACE FUNCTION usd.sp_add_user_email(user_data jsonb)
 RETURNS jsonb
 LANGUAGE plpgsql
AS $function$
DECLARE
    id_            integer          := 0;
BEGIN
    PERFORM
        1
    FROM
        usd.user_emails
    WHERE
		email = ( user_data::jsonb#>>'{"email"}' )::varchar
    LIMIT
        1;

    IF FOUND
    THEN
--        -- Запис з таким email вже існує ------------------------------------
        RETURN jsonb_build_object( 'error', 1110 );
    END IF;

    -- INSERT NEW VALUE ---------------------------------------------------
    INSERT INTO
        usd.user_emails
        (
            email,
            subscribe
        )
    VALUES
        (
            ( user_data::jsonb#>>'{"email"}' )::varchar,
            true
        )
    RETURNING
        id
    INTO
        id_;


    -- RETURN NEW ID --------------------------------------------
   RETURN jsonb_build_object( 'data', jsonb_build_object( 'id', id_ ) );
END;
$function$
;;
INSERT INTO usd.usd_value
("date", value)
VALUES('2024-05-19', 1.0);
INSERT INTO usd.usd_value
("date", value)
VALUES('2024-05-20', 1.0);
INSERT INTO usd.usd_value
("date", value)
VALUES('2024-05-21', 3.0);
INSERT INTO usd.usd_value
("date", value)
VALUES('2024-05-22', 4.0);
INSERT INTO usd.usd_value
("date", value)
VALUES('2024-05-23', 5.0);
INSERT INTO usd.usd_value
("date", value)
VALUES('2024-05-24', 6.0);
INSERT INTO usd.usd_value
("date", value)
VALUES('2024-05-25', 7.0);
INSERT INTO usd.usd_value
("date", value)
VALUES('2024-05-26', 8.0);

INSERT INTO usd.user_emails
(email, subscribe)
VALUES('test', true);
INSERT INTO usd.user_emails
(email, subscribe)
VALUES('test2@mail.com', true);
INSERT INTO usd.user_emails
(email, subscribe)
VALUES('test3@mail.com', true);
CREATE OR REPLACE FUNCTION usd.sp_select_emails()
 RETURNS jsonb
 LANGUAGE plpgsql
 COST 1
AS $function$
/**
 * Функція вибору налаштування системи
 */
declare
    data_           jsonb       := '{"data":[]}'::jsonb;
BEGIN
	-- SELECT DATA -------------------------------------------------------------
   EXECUTE
   '
        SELECT
            row_to_json(z)::jsonb
        FROM
            (
                SELECT
                    jsonb_agg(z1)   as "data"
                FROM
                (
                    SELECT
                        email
                    FROM
                        usd.user_emails
                ) z1
            ) z
    '
    INTO
        data_;

    RETURN data_;
END;
$function$
;;
