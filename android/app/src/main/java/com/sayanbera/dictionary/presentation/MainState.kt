package com.sayanbera.dictionary.presentation

import com.sayanbera.dictionary.domain.model.DictionaryCategory
import com.sayanbera.dictionary.domain.model.WordItem

data class MainState(
    val inputWord: String = "",
    val selectedCategory: DictionaryCategory = DictionaryCategory.GENERAL,
    val isLoading: Boolean = false,
    val wordItem: WordItem? = null
)