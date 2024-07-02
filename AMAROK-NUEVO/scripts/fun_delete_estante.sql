CREATE OR REPLACE FUNCTION fun_delete_estante( wnom_estante	estante.estantNom%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE west estante.estantNom%TYPE;
    DECLARE wmessage VARCHAR;
    DECLARE westante estante.estantNom%TYPE;
    BEGIN
        wmessage='00000';
        SELECT estantNom INTO westante FROM estante WHERE estantNom = wnom_estante FOR UPDATE;
        SELECT nomestant INTO west FROM bandeja WHERE nomestant=wnom_estante;
        IF  NOT FOUND THEN
            DELETE FROM estante
            WHERE estantNom = wnom_estante;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage='Error al eliminar';
                RETURN wmessage;
            END IF;
        ELSE
            wmessage='El estante no se puede eliminar porque está asociado a alguna bandeja';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;