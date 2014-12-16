<?php

namespace Application\Constants;

class Constants
{
    // MOODS
	const HAPPY = 0;
	const UNHAPPY = 1;

	// ROLES
	const ADMIN = 0;
	const STUDENT = 1;
	const STAFF = 2;
	
	// GENDER
	const MALE = 0;
	const FEMALE = 1;
	
	// STAFF
	const TEACHER = 0;
	const DIRECTOR = 1;
	
	// PROFILE TYPE
	const PROFILE_SCHOOL = 0;
	const PROFILE_STUDENT = 1;
	const PROFILE_STAFF = 2;

	// STYLE 
	const STYLE_LIGHT = 0;
	const STYLE_DARK = 1;
	
	// GIFT
	const GIFT_HEART = 0;
	const GIFT_HANDSHAKE = 1;
	const GIFT_BOMB = 2;
	
	public static function moodsToArray()
	{
		return array(
			Constants::HAPPY => 'Feliz',
			Constants::UNHAPPY => 'Triste',
		);
	}
	
	public static function rolesToArray()
	{
	    return array(
    		Constants::ADMIN => 'Administrador',
    		Constants::STUDENT => 'Estudante',
	        Constants::STAFF => 'Funcionário',
	    );
	}
	
	public static function genderToArray()
	{
	    return array(
    		Constants::MALE => 'Masculino',
    		Constants::FEMALE => 'Feminino',
	    );
	}
	
	public static function membershipTypeToArray()
	{
	    return array(
    		Constants::TEACHER => 'Professor',
    		Constants::DIRECTOR => 'Diretor',
	    );
	}
	
	public static function profileToArray()
	{
	    return array(
    		Constants::PROFILE_SCHOOL => 'Escola',
        	Constants::PROFILE_STUDENT => 'Aluno',
        	Constants::PROFILE_STAFF => 'Funcionário'
	    );
	}
	
	public static function styleToArray()
	{
	    return array(
    		Constants::STYLE_LIGHT => 'Claro',
        	Constants::STYLE_DARK => 'Escuro'
	    );
	}
	
	public static function academicYearsToArray()
	{
        return array(
    	    '5' => 'Quinta Série',
    	    '6' => 'Sexta Série',
    	    '7' => 'Sétima Série',
    	    '8' => 'Oitava Série',
    	    '9' => 'Nona Série',
    	    '10' => 'Primeiro Ano',
    	    '20' => 'Segundo Ano',
    	    '30' => 'Terceiro Ano'
        );
	}
}