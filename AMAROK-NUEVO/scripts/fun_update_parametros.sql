CREATE OR REPLACE FUNCTION fun_update_parametros(wnit_empresa parametros.empreNit%TYPE, wnom_empresa parametros.empreNom%TYPE,
                                            wdirec_empresa parametros.empreDir%TYPE,
                                            wtelef_empresa parametros.empreTel%TYPE,
                                            wcelul_empresa parametros.empreCel%TYPE,
                                            wcorreo_empresa parametros.empreEma%TYPE,
                                            wnumfacini_empresa parametros.numFacIni%TYPE,
											wredpundes_empresa parametros.redPunDes%TYPE,
                                            wredpundom_empresa parametros.redPunDom%TYPE,
                                            wtiemposalir_empresa parametros.tiempoSalir%TYPE,
											wadmincon_empresa parametros.adminCon%TYPE,
                                            wuser_update parametros.usr_update%TYPE,
                                            wuser_update_rol parametros.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wempresa parametros.empreNit%TYPE;
    BEGIN
        wmessage='00000';
        SELECT empreNit INTO wempresa FROM parametros FOR UPDATE;
        IF wadmincon_empresa  IS NOT NULL AND wadmincon_empresa != '' THEN
            UPDATE parametros SET empreNom      = wnom_empresa,
                                    empreDir    = wdirec_empresa,
                                    empreTel    = wtelef_empresa,
                                    empreCel    = wcelul_empresa,
                                    empreEma    = wcorreo_empresa,
                                    numFacIni   = wnumfacini_empresa,
                                    redPunDes       = wredpundes_empresa,
                                    redPunDom       = wredpundom_empresa,
                                    tiempoSalir     = wtiemposalir_empresa,
                                    adminCon        = wadmincon_empresa,
                                    usr_update      = wuser_update,
                                    usr_update_rol  = wuser_update_rol,
                                    fec_update      = now()
            WHERE empreNit = wnit_empresa;
        ELSE
            UPDATE parametros SET      empreNom       = wnom_empresa,
                                empreDir        = wdirec_empresa,
                                empreTel        = wtelef_empresa,
                                empreCel        = wcelul_empresa,
                                empreEma        = wcorreo_empresa,
								numFacIni		= wnumfacini_empresa,
                                redPunDes       = wredpundes_empresa,
                                redPunDom       = wredpundom_empresa,
                                tiempoSalir     = wtiemposalir_empresa,
                                usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
            WHERE empreNit = wnit_empresa;
        END IF;

        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;