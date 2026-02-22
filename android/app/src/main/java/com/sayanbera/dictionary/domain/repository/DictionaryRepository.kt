package com.sayanbera.dictionary.domain.repository

import com.sayanbera.dictionary.domain.model.DictionaryCategory
import com.sayanbera.dictionary.domain.model.WordItem
import com.sayanbera.dictionary.util.Result
import kotlinx.coroutines.flow.Flow

interface DictionaryRepository {
    suspend fun getWordResult(
        word: String,
        category: DictionaryCategory
    ): Flow<Result<WordItem>>
}