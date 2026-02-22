package com.sayanbera.dictionary.data.remote

import com.sayanbera.dictionary.data.dto.WordResultDto
import retrofit2.http.GET
import retrofit2.http.Path
import retrofit2.http.Query

interface DictionaryApi {

    @GET("/api/v2/entries/en/{word}")
    suspend fun getWordResult(
        @Path("word") word: String,
        @Query("category") category: String
    ): WordResultDto

}